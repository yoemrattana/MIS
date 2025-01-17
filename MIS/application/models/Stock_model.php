<?php
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MessageSender;

class Stock_model extends CI_Model
{
    public function notify()
	{
        $items = $this->getNearExpiredStock();

        foreach ($items as $item) {
            $this->sendMsg( $item );
        }
	}

    private function sendMsg( $item )
    {
        $msg = new SingleMessage();
		$sender = new MessageSender( $msg );

        $tokens = $this->getTokens( $item );

        foreach($tokens as $token) {
            $body = $this->setTemplate($item);
            $title = "ស្ថានភាពថ្នាំគ្រុនចាញ់";

            $msg->setMessage( $token, $title, $body );
            $sender->send();
        }

        sleep(0.2);
    }

    private function getTokens( $item )
    {
        $this->load->model('Token_model');
        $hcTokens = $this->Token_model->getHCToken($item['Code_Facility_T']);
        $cmiTokens = $this->Token_model->getTokenCmiByHC($item['Code_Facility_T']);

        return array_merge($hcTokens, $cmiTokens['tokens']);
    }

    private function setTemplate( $row ) {
        $sql = "select * from tblNotificationTemplates";
		$template = $this->db->query($sql)->row_array()['NearExpiredStock'];

		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{item}', $row['Description'], $template);
		$template = str_replace('{date}', $row['Date'], $template);

		return $template;
    }

    private function getNearExpiredStock()
    {
        $stocks = $this->getStock();

        $expiredItem = [];
        foreach($stocks as $row) {
            $item = $this->getNearExpiredItem($row);
            if( $item['Qty'] > 0 ) $expiredItem[] = $item;
        }

        return $expiredItem;
    }

    private function getNearExpiredItem($item)
    {
        $expireDetail = json_decode($item['ExpireDetail']);

        $items = array_map(function($ex) {
            $now = date_create(date('Y-m-d'));
            $expiredDate = date_create($ex->Date);
            $dateDiff = date_diff($now, $expiredDate)->format("%R%a");
            if($dateDiff < 30 && $dateDiff>0 && $ex->Qty > 0) {
                return [
                    'Date' => $ex->Date,
                    'Qty' => $ex->Qty
               ];
            }
        }, $expireDetail);

        $item['Date'] = $items[0]['Date'];
        $item['Qty'] = $items[0]['Qty'];

        return $item;
    }

    private function getStock()
    {
        $sql = "select a.Code_Facility_T, Name_Prov_E, Name_Prov_K, b.Name_OD_E, b.Name_OD_K, b.Name_Facility_E, b.Name_Facility_K,
                d.Code, d.Description, ExpireDetail
                from tblStockV2 as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
                join tblStockItems as d on d.Id = a.ItemId
                where concat(year, month) = FORMAT(DATEADD(MONTH, -1,GETDATE()), 'yyyyMM') and b.IsTarget = 1 and ExpireDetail is not null and ExpireDetail != '[]'";

        return $this->db->query($sql)->result_array();
    }
}