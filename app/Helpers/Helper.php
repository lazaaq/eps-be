<?php
if (! function_exists('comCd')) {
    function comCd($id){
        $comCodeName = App\Component::where('com_cd', $id)->first();
        return $comCodeName->code_nm;
    }
}
if (! function_exists('comGroup')) {
    function comGroup($name){
        $codeGroup = App\Component::where('code_group', $name)->get();
        return $codeGroup;
    }
}
