<?php
if(Input::exists()) {
    if(Input::get('staff')) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'max' => 60,
            ),
            'email' => array(
                'required' => true,
                'unique' => 'users',
                'max' => 60,
            ),
            'password1' => array(
                'required' =>true,
                'min' => 6
            ),
            'password2' => array(
                'required' =>true,
                'matches' =>'password1',
            )
        ));

        if (!empty($_FILES['pic'])) {
            $validation->checkPic2('pic');
        }
        if($validation->passed()) {
            $salt = Hash::salt(32);

            try {
                $user = new User();
                $pic = "img/avatar-male.png";
                if(!empty($_FILES['pic'])) {
                    $pic = $user->movePic('pic');
                }
                $user->create(array(
                    'name' => Input::get('name'),
                    'password' => Hash::make(Input::get('password1'),$salt),
                    'email' => Input::get('email'),
                    'pic' => $pic,
                    'salt' => $salt,
                ));
                Session::flash('home', "Admin added successfully");
                Redirect::to('register');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $key => $error) {
                Routes::$errors[] = $error;
            }
            Session::flash('errors', implode("::", Routes::$errors));
            Redirect::to('register');
        }
    }
}
Session::flash('home', "Enter the details correctly.");
//Redirect::to('register');