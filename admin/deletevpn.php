<?php
if(!empty(escape($Qstring))) {
    try{
        $vpnObj->delete(['id', '=', escape($Qstring)]);
        Session::flash('home', "VPN deleted");
        Redirect::to("dashboard");
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
Session::flash('home', "Error deleting category. Try again");
Redirect::to("dashboard");