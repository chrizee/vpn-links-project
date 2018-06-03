<?php
if(Input::exists()) {
    if(!empty(Input::get('updateuser'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'max' => 60,
            ),
            'email' => array(
                'required' => true,
                //'unique' => 'users',
                'max' => 60,
            ),
            'password1' => array(
                'min' => 6
            ),
            'password2' => array(
                'matches' =>'password1',
            )
        ));

        if (!empty($_FILES['pic'])) {
            $validation->checkPic2('pic');
        }

        if ($validation->passed()) {
            $user = new User();
            try {
                $picname = (!empty($user->data()->pic)) ? $user->data()->pic : '';
                if (!empty($_FILES['pic'])) {
                    if ($name = $user->movePic('pic')) {
                        unlink('img/users/'.$picname);
                        $picname = $name;
                    }
                }
                if(!empty(Input::get('password1')) && !empty(Input::get('password2'))) {
                    $salt = Hash::salt(32);
                    $user->update(array(
                        'name' => Input::get('name'),
                        'email' => Input::get('email'),
                        'salt' => $salt,
                        'password' => Hash::make(Input::get('password1'),$salt),
                        'pic' => $picname
                    ));
                    Session::flash('home', 'Password changed');
                    Redirect::to('profile');
                }else {
                    $user->update(array(
                        'name' => Input::get('name'),
                        'email' => Input::get('email'),
                        'pic' => $picname
                    ));
                }
                Session::flash('home', 'Profile updated');
                Redirect::to('profile');
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $key => $error) {
                Routes::$errors[] = $error;
            }
            Session::flash('errors', implode("::", Routes::$errors));
            Redirect::to('profile');
        }
    }
}
Session::flash('home', 'Enter the required information correctly');
Redirect::to('profile');