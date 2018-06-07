<?php
if(!empty(escape($Qstring))) {
    try{
        $vpn = $vpnObj->get(['id', '=', escape($Qstring)]);
        if(empty($vpn)) {
            Session::flash('home', "Select a valid VPN");
            Redirect::to('dashboard');
        }
        if(file_exists($vpn[0]->file_url)) @unlink($vpn[0]->file_url);
        $vpnObj->delete(['id', '=', escape($Qstring)]);
        Session::flash('home', "VPN deleted");
        Redirect::to("dashboard");
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
Session::flash('home', "Error deleting category. Try again");
Redirect::to("dashboard");