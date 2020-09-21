<?php
class flmBaseController
{
    public static function update()
    {
        $data = file_get_contents("php://input");
        die($data);
    }

    public static function toggleActivation()
    {
        echo "<script>console.log(" . get_option("flm_status") . ");</script>";
        $status = (get_option("flm_status") == 1) ? 0 : 1;
        update_option("flm_status", $status);
        wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit();
    }

    public static function saveModalData()
    {
        check_admin_referer('flm-model-form');
        $data = $_POST;
        $data["links"] = array_filter($data["links"], function($idx) {
            return !empty($idx["title"]) || !empty($idx["link"]);
        });
        unset($data["_wpnonce"]);
        unset($data["_wp_http_referer"]);
        unset($data["action"]);
        $json = json_encode($data);
        if (empty(get_option("flm_modal_data"))) {
            add_option('flm_modal_data', $json);
        } else {
            update_option('flm_modal_data', $json);
        }
        wp_redirect($_POST["_wp_http_referer"]);
        exit();
    }
}
