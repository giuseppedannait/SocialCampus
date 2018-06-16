<?php

namespace App\Http\Controllers;

    use App\SocialChannel;
    use Facebook\Exceptions\FacebookSDKException;
    use Facebook\Facebook;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    private $api;

    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->facebook_access_token);
            $this->api = $fb;
            dd($next($request));
            return $next($request);
        });
    }

    public function retrieveUserProfile(){
        try {

            $params = "first_name,last_name,age_range,gender";

            $user = $this->api->get('/me?fields='.$params)->getGraphUser();

            dd($user);

        } catch (FacebookSDKException $e) {

        }

    }

    public function getFacebookPages(){

        try {

            $response = $this->api->get('/me/accounts', Auth::user()->facebook_access_token);
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();

            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();

            exit;
        }

        try {
            $pages = $response->getGraphEdge()->asArray();

                return $pages;

            } catch (FacebookSDKException $e) {
            dd($e); // handle exception
            }
    }

    public function getFacebookPagesToArray(){

        $fb = new Facebook();
        $fb->setDefaultAccessToken(Auth::user()->facebook_access_token);

        $response = $fb->get('/me/accounts');

        $pages = $response->getGraphEdge()->asArray();

        return $pages;
    }

    public function publishToProfile(Request $request){
        try {
            $response = $this->api->post('/me/feed', [
                'message' => $request->message
            ])->getGraphNode()->asArray();
            if($response['id']){
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function getPageAccessToken($page_id){
        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $this->api->get('/me/accounts', Auth::user()->facebook_access_token);
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        try {
            $pages = $response->getGraphEdge()->asArray();
            foreach ($pages as $key) {
                if ($key['id'] == $page_id) {
                    return $key['access_token'];
                }
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function publishToPage($channel, $post){

        $page = new SocialChannel();

        $fb = new Facebook();
        $fb->setDefaultAccessToken(Auth::user()->facebook_access_token);

        $page_access_token = $page::where('id', $channel)
            ->pluck('access_token')
            ->first();

        $page_id = $page::where('id', $channel)
            ->pluck('channel_id')
            ->first();

        $fb_response="";

        switch ($post['type']) {

            case 'simple':

                try {
                    $fb_response = $fb->post('/' . $page_id . '/feed', $post, $page_access_token);
                } catch (FacebookSDKException $e) {
                    dd($e); // handle exception
                }

                break;

            case 'image' :

                try {

                    if($post['source']) {
                        $post['source'] = $fb->fileToUpload($post['source']);
                    }
                    else {
                        $post['source']="";
                    }

                } catch (FacebookSDKException $e) {
                    dd($e); // handle exception
                }

                try {
                    $fb_response = $fb->post('/' . $page_id . '/photos', $post, $page_access_token);
                } catch (FacebookSDKException $e) {
                    dd($e); // handle exception
                }

                break;

            case 'link':

                try {
                    $fb_response = $fb->post('/' . $page_id . '/feed', $post, $page_access_token);
                } catch (FacebookSDKException $e) {
                    dd($e); // handle exception
                }

                break;
        }

        return $fb_response;

    }

    public function publishImageToPage(Request $request){

        $absolute_image_path = '/var/www/SocialCampus/storage/app/images/socialmediatimemanagement.jpg';

        try {

            $response = $this->api->post('/me/feed', [
                'message' => $request->message,
                'source'    =>  $this->api->fileToUpload($absolute_image_path)
            ])->getGraphNode()->asArray();

            if($response['id']){
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function publishImageToProfile(Request $request){
        $absolute_image_path = '/var/www/larave/storage/app/images/lorde.png';
        try {
            $response = $this->api->post('/me/feed', [
                'message' => $request->message,
                'source'    =>  $this->api->fileToUpload('/path/to/file.jpg')
            ])->getGraphNode()->asArray();

            if($response['id']){
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function getFacebookPagePosts($page_name){

        $fb = new Facebook();
        $fb->setDefaultAccessToken(Auth::user()->facebook_access_token);

        $page = new SocialChannel();

        $page_token = $page::where('name', $page_name)
            ->pluck('access_token')
            ->first();

        try {

            $response = $fb->get('me?fields=id,name,posts', $page_token);

            $posts = $response->getGraphNode()->asArray();

            return $posts;

        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }

    }

}
