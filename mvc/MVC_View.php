<?php

##
##  БАЗОВЫЙ КЛАСС ПРЕДСТАВЛЕНИЯ
##  #######################

class MVC_View{

    public  function __construct(){
        ##  конструктор
    }

    public  function __destruct(){
        ##  деструктор
    }


    public  function render($file, $params = []){
        ##  рендеринг на основе указанного шаблона
        $ob_level = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try{
            require $file;
            return ob_get_clean();
        }
        catch(\Exception $e){
            while (ob_get_level() > $ob_level){
                if (!@ob_end_clean()){
                    ob_clean();
                }
            }
            throw $e;
        }
        catch(\Throwable $e){
            while (ob_get_level() > $ob_level){
                if (!@ob_end_clean()){
                    ob_clean();
                }
            }
            throw $e;
        }
    }

}
