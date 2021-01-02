<?php
namespace feelcom\wsb;



class ApiController extends Controller{

    protected function getName() {
        return 'api';
    }

    protected function Index(){

        //check is request has "action" paramerts
        if(isset($_POST['action']))
        {

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $method = $post['action'];

            unset($post['action']);

            $param= implode(',',$post);

            $model = new Api();

            // debuging ajax form options
            if($method=='sendReservationFormAjax'){
              //var_dump($post,$param);
            }


            //chek is method exist
            if($model->actionExist($method)){

                echo json_encode($model->$method($param));

            }
            else {
                $this->returnView('../home/404');
            }
        }
        else{
            $this->returnView('../home/404');
        }

    }

    protected function error(){
        $this->returnView('../home/404');
    }

}
?>