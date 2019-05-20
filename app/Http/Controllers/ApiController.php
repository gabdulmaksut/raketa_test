<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Request, App, Validator, DB, Hash, Cookie, Auth;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\toJson;;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\User;

class ApiController extends Controller
{
    public function getIndex()
    {
        return \view('index');
    }

    public function postIndex()
    {
        $username = Input::get('username');

        $followers = $this->getFollowers($username);
        print_r($followers);// на кого он подписан

        $a = array(array());
        $i= 0;
        foreach($followers as $foll){ 
            $a = array_merge($a, $this->getFollowers($followers[$i]));   
            $i = $i+1;          
        }

        print_r($a);//подписки его подписок (заполняет подписками последнего)

        $info = $this->getInfo($username);
        $saved = $this->saveUser($username, $info);
                
    }


    private function getResult($url){

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get( $url, [
            'form_params' => [
                'cliend_id' => 'gabdulmaksut',
                'client_secret' => '3972a66f58ee3a1979d5f206190db47da6568c77'
            ]
        ])->getBody()->getContents();
        return $result;
        
    }

    public function getUsersRequests(){
        $users = User::orderBy('repos', 'DESC')->get();
        return view('usersrequests')->with('users', $users);
    }

    private function getFollowers($username){

        $followers_url = 'https://api.github.com/users/'.$username.'/following';
        $result = $this->getResult($followers_url);

        $content = json_decode($result, true);
        $followers = array();
        foreach ($content as $cont) {
            array_push($followers, $cont['login']);
        }
        return $followers;
    }

    private function saveUser($username, $info){
        $user = User::firstOrCreate(['username' => $username]);
        $user->name = !empty($info[0]) ? $info[0] : 'null';
        $user->email = !empty($info[1]) ? $info[1] : 'null';
        $user->followers = !empty($info[2]) ? $info[2] : '0';
        $user->following = !empty($info[3]) ? $info[3] : '0';
        $user->repos = !empty($info[4]) ? $info[4] : '0';
        $user->save();
        return 'saved';

    }

    private function getInfo($username){
        $repos_url = 'https://api.github.com/users/'.$username;
        $result = $this->getResult($repos_url);
        
        $content = json_decode($result, true);
        //dd($content);
        $info = array();
            array_push($info, $content['name'], $content['email'], $content['followers'], $content['following'], $content['public_repos']);
        
        //dd($repos);
        return $info; 
    }
}