<?php
/// http://snipplr.com/view/9399/     

function V_EMPTY($str){
    $err_msg = "必須項目です。";
    if($str != null){
        return null;
    }
    return $err_msg;
}

function V_NUMBER($str){
    $err_msg = "半角数字で入力してください。";
    if(preg_match("/^[0-9]+$/", $str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_ALPHA($str){
    $err_msg = "半角英字で入力してください。";
    if(preg_match("/^[a-zA-Z]+$/", $str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_ALPHA_NUMBER($str){
    $err_msg = "半角英数字で入力してください。";
    if(preg_match("/^[a-zA-Z0-9]+$/", $str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_URL($str){
    $err_msg = "URLが不正です。";
    if(preg_match('/^(http|HTTP|ftp)(s|S)?:\/\/+[A-Za-z0-9]+\.[A-Za-z0-9]/',$str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_MAIL($str){
    $err_msg = "メールアドレスが不正です。";
    $match = '/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i';

    if(preg_match($match, $str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_ZEN_KATA($str){
    $err_msg = "全角カタカナで入力してください。";
    if(preg_match("/^[ァ-ヶ]+$/u",$str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_ZEN_HIRA($str){
    $err_msg = "全角ひらがなで入力してください。";
    if(preg_match("/^[ぁ-ん]+$/u",$str) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_ZEN_LENGH($str, $min=0, $max=500){
    $utf = "utf-8"; //文字コード
    $err_msg = $min ."文字以上". $max."文字以内で入力してください。";
    if((mb_strlen($str,$utf) >= $min && mb_strlen($str,$utf) <= $max) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_HAN_LENGH($str, $min=0, $max=500){
    $err_msg = $min ."文字以上". $max."文字以内で入力してください。";
    if((strlen($str) >= $min && strlen($str) <= $max) || $str == ""){
        return null;
    }
    return $err_msg;
}

function V_RANGE($str, $min=0, $max=500){
    $err_msg = $min ."〜". $max."の範囲で入力してください。";
    if(((int)$str >= (int)$min && (int)$str <= (int)$max) || $str == ""){
        return null;
    }
    return $err_msg;
}
?>
