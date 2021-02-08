<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\NewUser;

class UserController extends Controller
{

    public function index(){
        //проверка

        $sort = request('sort');
        $field = request('field');
        //$page = request('page');

        if ($sort == 'asc'||$sort == 'desc')
            if($field == 'id'||
            $field == 'login'||
            $field == 'name'||
            $field == 'email') {
                $users = NewUser::orderBy($field, $sort)->paginate(5);
                $users->appends(['field'=>$field, 'sort'=>$sort]);
            }
            else {
                $users = NewUser::orderBy('Id', $sort)->paginate(5);
                $users->appends(['sort'=>$sort]);
            }
        else
            //$users = NewUser::all()->paginate(5);
            $users = NewUser::paginate(5);

        return view('home', [
            'users'=>$users,
            'sort'=>$sort,
            'field'=>$field,
            'message'=>session('message')
        ]);
    }

    public function add(){
        return view('add');
    }

    public function store(){
        if(request('login') != "" && request('password') != "") {
            $user = new NewUser();
            $user->login = request('login');
            $user->password = request('password');
            if (request('name') != "")
                $user->name = request('name');
            else
                $user->name = request('login');
            if (request('email') != "")
                $user->email = request('email');
            else
                $user->email = request('login') . "@example.com";


            $tempUser = NewUser::where('login', request('login'))->get();
            if(count($tempUser)==0) {
                $user->save();
            }
        }
        return redirect('/');
    }

    public function edit($id){
        $user = Newuser::findOrFail($id);
        return view('edit', ['user'=>$user, 'message'=>session('message')]);
    }

    public function update(){
        if(request('login') != "" && request('password') != "") {
            $user = new NewUser();

                $user->Login = request('login');
                $user->Password = request('password');
                if (request('name') != "")
                    $user->Name = request('name');
                else
                    $user->Name = request('login');
                if (request('email') != "")
                    $user->Email = request('email');
                else
                    $user->Email = request('login') . "@example.com";


                $tempUser = NewUser::where('login', request('login'))->get();
                if (count($tempUser) == 0) {
                    DB::update('update users set login = ?, password = ?,
                    name = ?, email = ? where id = ?', [$user->Login, $user->Password,
                        $user->Name, $user->Email, request('id')]);
                    $message = 'Пользователь изменен';
                    return redirect('/')->with('message', $message);;
                }
                else
                {
                    $message = 'Пользователь с таким логином уже существует';
                    return redirect('/'.request('id')."/edit")->with('message', $message);;
                }
            }


    }

    public function import(){
        return view('import');
    }

    function importXML($file){
        $usersxml = simplexml_load_file($file);
        $users = array();
        $commonUsers = array();
        echo $usersxml[0];
        $i = 0;
        $j = 0;
        $numrows = DB::table('users')->count();
        foreach($usersxml as $user) {
            $users[$i]['login'] = $user->login;
            $users[$i]['password'] = $user->password;
            $users[$i]['name'] = $user->login;
            $users[$i]['email'] = $user->login . '@example.com';


            $tempUser = NewUser::where('login', $user->login)->get();

            if(count($tempUser)>0){
                $commonUsers[$j]['login'] = $user->login;
                $commonUsers[$j]['newpassword'] = $user->password;
                $j++;
            }
            $i++;
        }

        $query_delete = "DELETE FROM users WHERE ";

        if(count($commonUsers)>0){
            if(count($commonUsers)==1){
                $query_delete .= "Login <> \"" .$commonUsers[0]['login'] ."\"";
            } else if (count($commonUsers)>1){
                $query_delete .= "Login <> \"" .$commonUsers[0]['login'] ."\"";
                for($i=1; $i<count($commonUsers); $i++){
                    $query_delete = $query_delete . " and Login <> \"" .$commonUsers[$i]['login'] ."\"";
                }
            }
            $res = DB::delete($query_delete);
        }
        else{
            NewUser::truncate();
        }
        $deleted = $numrows - count($commonUsers);

        for($i=0;$i<count($users);$i++){
            DB::table('users')->upsert(
                ['login'=>$users[$i]['login'], 'password'=>$users[$i]['password'], 'name'=>$users[$i]['name'], 'email'=>$users[$i]['email']],
                ['login'],
                ['password', 'name', 'email']
            );
        }
        return 'Импортирован файл. Обработано записей - '. ($numrows+count($users)-count($commonUsers)) . '; Обновлено записей - '. count($commonUsers). '; Удалено записей - '. $deleted . '.';

    }

    function importCSV($file){
        $users = array();
        $commonUsers = array();
        $i = 0;
        $j = 0;
        $numrows = DB::table('users')->count();
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($i>0){
                    $users[$i-1]['login'] = $data[0];
                    $users[$i-1]['password'] = $data[1];
                    $users[$i-1]['name'] = $data[0];
                    $users[$i-1]['email'] =$data[0] . '@example.com';

                    $tempUser = NewUser::where('login', $data[0])->get();

                    if(count($tempUser)>0){
                        $commonUsers[$j]['login'] = $data[0];
                        $commonUsers[$j]['newpassword'] = $data[1];
                        $j++;
                    }
                }
                $i++;
            }
        }
        fclose($handle);

        $query_delete = "DELETE FROM users WHERE ";

        if(count($commonUsers)>0){
            if(count($commonUsers)==1){
                $query_delete .= "Login <> \"" .$commonUsers[0]['login'] ."\"";
            } else if (count($commonUsers)>1){
                $query_delete .= "Login <> \"" .$commonUsers[0]['login'] ."\"";
                for($i=1; $i<count($commonUsers); $i++){
                    $query_delete = $query_delete . " and Login <> \"" .$commonUsers[$i]['login'] ."\"";
                }
            }
            $res = DB::delete($query_delete);
        }
        else{
            NewUser::truncate();
        }
        $deleted = $numrows - count($commonUsers);

        for($i=0;$i<count($users);$i++){
            DB::table('users')->upsert(
                ['login'=>$users[$i]['login'], 'password'=>$users[$i]['password'], 'name'=>$users[$i]['name'], 'email'=>$users[$i]['email']],
                ['login'],
                ['password', 'name', 'email']
            );
        }
        return 'Импортирован файл. Обработано записей - '. ($numrows+count($users)-count($commonUsers)) . '; Обновлено записей - '. count($commonUsers). '; Удалено записей - '. $deleted . '.';

    }

    public function upload(){
        $file = $_FILES['file'];
        $extensions= array("xml","csv");
        $tmp = explode('.',$file['name']);
        $file_ext=strtolower(end($tmp));
        if(in_array($file_ext,$extensions)=== false){
            $errors[]='Разрешены только .xml и .csv файлы';
        }
        if($file['size'] > 2097152) {
            $errors[]="Размер не должен превышать 2 МБ";
        }
        if(empty($errors)==true) {
            request('file')->move('uploads', $file['name']);
            if($file_ext=='xml')
                $message = UserController::importXML('uploads/'.$file['name']);
            else if($file_ext=='csv')
                $message = UserController::importCSV('uploads/'.$file['name']);
            return redirect('/')->with('message', $message);
        }else{
            print_r($errors);
            return view('import');
        }


    }


}
