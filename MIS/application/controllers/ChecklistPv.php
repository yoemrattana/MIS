<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChecklistPv extends MY_Controller
{
	public function index()
	{
        //phpinfo();
        if (!isset($_SESSION['permiss']['Health Center Data'])) redirect('Home');

		$data['title'] = "Check list Pv Raidcal cure";
		$data['main'] = 'checklist_pv_view';

		$this->load->view('layout', $data);
	}

    public function getList()
    {
        $sql = "select c.Code_Prov_T, b.Code_OD_T, a.* from tblChecklistPv as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T";

        $rs = $this->db->query( $sql )->result_array();

        $this->output->set_output( json_encode( $rs ) );
    }

    private function getChecklist($id)
    {
        $sql = "select c.Code_Prov_T, b.Code_OD_T, a.* from tblChecklistPv as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T
                where a.Rec_ID = {$id}";

        return $this->db->query( $sql )->row_array();
    }

	public function getDetail()
    {
        $parentId = $this->input->post('Rec_ID');
        $data = [];
        if ( empty( $parentId) ){
            $data = $this->getField();
            $data['Items']  = $this->db->get_where( 'tblChecklistPvAttribute' , ['Visible' => true] )->result_array();
        } else {
            $sql = "select c.Code_Prov_T, b.Code_OD_T, a.* from tblChecklistPv as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T
                where Rec_ID = {$parentId}";

            $data = $this->db->query( $sql )->row_array();

            $sql = "select * from tblChecklistPvAttribute as a
                    left join tblCheckListPvValue as b on a.AttributeID = b.AttributeID and b.ParentID = {$parentId}
                    where Visible = 1 ";

            $data['Items']  = $this->db->query( $sql )->result_array();
        }

		$this->output->set_output( json_encode( $data ) );
    }

    public function save()
    {
        $submit = $this->input->post('submit');

        $details = $submit['Children'];

        $parentId = $submit['Rec_ID'];
        unset( $submit['Children'], $submit['Code_OD_T'], $submit['Code_Prov_T'], $submit['Rec_ID'] );

        if ( empty($parentId) ) {
            $submit['InitTime'] = sqlNow();
            $submit['InitUser'] = $_SESSION['username'];

            $this->db->insert('tblChecklistPv', $submit);
            $parentId = $this->db->insert_id();
        } else {
            $submit['ModiTime'] = sqlNow();
            $submit['ModiUser'] = $_SESSION['username'];

            $this->db->update('tblChecklistPv', $submit, ['Rec_ID' => $parentId]);
        }

        $this->db->delete('tblCheckListPvValue', ['ParentID' => $parentId]);

        foreach( $details as $detail ) {
            $section = isset($detail['Section']) ? $detail['Section'] : '';

            unset( $detail['Sort'], $detail['Subscore'], $detail['Section'], $detail['ShortName'], $detail['AttributeName'] );

            $detail['ParentID'] = $parentId;

            if(isset($detail['Value']) &&  $section == '3-1-1') {
                $detail['Value'] = json_encode($detail['Value']);
            }

            unset($detail['DataType']);

            $this->db->insert( 'tblCheckListPvValue', $detail );
        }

        $chklist = $this->getChecklist($parentId);
        $this->output->set_output( json_encode($chklist) );
    }

    private function getField()
    {
        $rs = $this->db->list_fields('tblChecklistPv');
        $fields = [];
        foreach ($rs as $v) {
            $fields[$v] ='';
        }

        return $fields;
    }

	public function runSeeder()
    {
        return;
		//$this->db->truncate('tblChecklistPvAttribute');
        $this->db->insert_batch('tblChecklistPvAttribute', $this->seedDB());
    }

    public function updateSeeder()
    {
        $this->db->insert_batch('tblChecklistPvAttribute', $this->updateSeedDb());
    }

    public function updateSeedDb()
    {
        return [
            [
                "AttributeName" => "G6PD LEVEL 1 G6PD:0.1-3-0; T-Hb: 6.0-12.0",
                "ShortName" => "g6pd_level_1",
                "Section" => "2-1-2",
                "DataType" => "float",
                "Sort" => 14.1,
                "Visible" => true
            ],
            [
                "AttributeName" => "G6PD LEVEL 2 G6PD:6.0-17.0; T-Hb: 13.0-20.0",
                "ShortName" => "g6pd_level_2",
                "Section" => "2-1-2",
                "DataType" => "float",
                "Sort" => 14.1,
                "Visible" => true
            ],

             [
                "AttributeName" => "T-Hb LEVEL 1 G6PD:0.1-3-0; T-Hb: 6.0-12.0",
                "ShortName" => "hb_level_1",
                "Section" => "2-1-2",
                "DataType" => "float",
                "Sort" => 14.2,
                "Visible" => true
            ],
            [
                "AttributeName" => "T-Hb LEVEL 2 G6PD:6.0-17.0; T-Hb: 13.0-20.0",
                "ShortName" => "hb_level_2",
                "Section" => "2-1-2",
                "DataType" => "float",
                "Sort" => 14.2,
                "Visible" => true
            ],
       ];
    }

	public function seedDB()
    {
		return
		[
			[
				"AttributeName" => "១.សមត្ថភាពមន្ត្រីមូលដ្ឋានសុខាភិបាល",
				"ShortName" => "hf_staff_capacity",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 1,
				"Visible" => true
			],
			[
				"AttributeName" => "២.សំភារៈនៅមូលដ្ឋានសុខាភិបាល",
				"ShortName" => "hf_comodity",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 2,
				"Visible" => true
			],
			[
				"AttributeName" => "៣.ការបញ្ចូលទិន្នន័យមូលដ្ឋានសុខាភិបាល",
				"ShortName" => "hf_data_entry",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 3,
				"Visible" => true
			],
			[
				"AttributeName" => "៤.ការធ្វើតេស្តរហ័ស",
				"ShortName" => "rdt_test",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 4,
				"Visible" => true
			],
			[
				"AttributeName" => "៥.ការធ្វើតេស្ត G6PD",
				"ShortName" => "g6pd_test",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 5,
				"Visible" => true
			],[
				"AttributeName" => "៦.ការធ្វើតេស្ត HEMOCUE",
				"ShortName" => "hemocue_test",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 6,
				"Visible" => true
			],[
				"AttributeName" => "៧.ការធ្វើតេស្តពិនិត្យស្ត្រីមានគភ៌",
				"ShortName" => "pregnancy_test",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 7,
				"Visible" => true
			],[
				"AttributeName" => "៨.ការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់(តាមមគ្គុទ្ទេសក៏ព្យាបាលគ្រុនចាញ់ថ្នាក់ជាតិ)",
				"ShortName" => "pv_treatment",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 8,
				"Visible" => true
			],[
				"AttributeName" => "៩.ផលរំខាននៃឱសថព្រីម៉ាគីន",
				"ShortName" => "primaquine_sideeffect",
				"Section" => "4-1-2",
				"DataType" => "int",
				"Sort" => 9,
				"Visible" => true
			],[
				"AttributeName" => "១. តើផ្នែកណាខ្លះដែលអ្នកបានទទួលចំនួន ៤ពិន្ទុ និង ៥ពិន្ទុ?",
				"ShortName" => "score_4_5",
				"Section" => "4-1-2-A",
				"DataType" => "nvarchar",
				"Sort" => 10,
				"Visible" => true
			],[
				"AttributeName" => "២. តើកត្តាអ្វីដែលធ្វើអោយអ្នកបានទទួលបានពិន្ទុដូចនៅក្នុងសំនួរទី ១? ",
				"ShortName" => "reason_score_4_5",
				"Section" => "4-1-2-A",
				"DataType" => "nvarchar",
				"Sort" => 11,
				"Visible" => true
			],[
				"AttributeName" => "៣. តើផ្នែកណាខ្លះដែលអ្នកបានទទួលពិន្ទុតិចជា ៤ ពិន្ទុ?",
				"ShortName" => "section_ls_4",
				"Section" => "4-1-2-A",
				"DataType" => "nvarchar",
				"Sort" => 12,
				"Visible" => true
			],[
				"AttributeName" => "៤.តើជំហានបន្ទាប់អ្នកត្រូវធ្វើដូចម្តេចដើម្បីធ្វើអោយប្រសើរឡើងនូវចំណុចខ្វះខាតទាំងនេះ?",
				"ShortName" => "how_to_improve",
				"Section" => "4-1-2-A",
				"DataType" => "nvarchar",
				"Sort" => 13,
				"Visible" => true
			],
			//section 1
			[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលទទួលបន្ទុកការព្យាបាលផ្តាច់នៅមូលដ្ឋានសុខាភិបាល",
				"ShortName" => "pv_supervisor",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 1,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានចូលរួមវគ្គបណ្តុះបណ្តាលរំលឹក ការគ្រប់គ្រងករណីជំងឺគ្រុនចាញ់។",
				"ShortName" => "refresher",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 2,
				"Visible" => true
			],[
				"AttributeName" => "សូមប្រាប់ឈ្មោះ៖_____",
				"ShortName" => "pv_supervisor_name",
				"Section" => "1-1",
				"DataType" => "nvarchar",
				"Sort" => 2,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រធ្វើតេស្តរហ័ស និងបកស្រាយលទ្ធផល។",
				"ShortName" => "staff_rdt",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 3,
				"Visible" => true
			],
			[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រធ្វើតេស្ត G6PD និងបកស្រាយលទ្ធផល។",
				"ShortName" => "staff_g6pd",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 4,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រធ្វើតេស្ត HEMOCUE និងបកស្រាយលទ្ធផល។(សូមរំលងប្រសិនបើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)",
				"ShortName" => "staff_hemocue",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 5,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រធ្វើតេស្តពិនិត្យរកស្រ្តីមានគភ៌ និងបកស្រាយលទ្ធផល។ (សូមរំលងប្រសិនបើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)",
				"ShortName" => "staff_preganacy",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 6,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រព្យាបាលផ្តាច់ តាមកម្រិតអង់ស៊ីម G6PD ទម្ងន់ និងអាយុរបស់អ្នកជំងឺគ្រុនចាញ់វីវ៉ាក់",
				"ShortName" => "staff_treat",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 7,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រផ្តល់ការប្រឹក្សាដល់អ្នកជំងឺដែលទទួលការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់",
				"ShortName" => "staff_consult",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 8,
				"Visible" => true
			],[
				"AttributeName" => "រាប់ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាលស្តីពីវិធីសាស្ត្រតាមដានការព្យាបាលផ្តាច់ (ឧ. តាមដានរោគសញ្ញាផលរំខានពីថ្នាំព្រីម៉ាគីន និងការកត់ត្រាការលេបថ្នាំព្រីម៉ាគីនតាមថ្ងៃដែលបានកំណត់)",
				"ShortName" => "staff_followup",
				"Section" => "1-1",
				"DataType" => "int",
				"Sort" => 9,
				"Visible" => true
			],
			//section 1-2
			[
				"AttributeName" => "តើសៀវភៅកត់ត្រាការព្យាបាលផ្តាច់ វីវ៉ាក់ប្រចាំខែ មាននៅសល់ទំព័រទំនេរយ៉ាងតិចណាស់ ៥ ទំព័រឬទេ?",
				"ShortName" => "pv_book_5p",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 1,
				"Visible" => true
			],[
				"AttributeName" => "តើមានសម្ភារៈជំនួយស្មារតីស្តីពីការប្រឹក្សាអ្នកជំងឺ (អ្នកជំងឺG6PDធម្មតា មធ្យមនិងខ្សោយ) ឬទេ?",
				"ShortName" => "support_material",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 2,
				"Visible" => true
			],[
				"AttributeName" => "តើមានប័ណ្ណព័ត៌មាននិងការព្យាបាលអ្នកជំងឺ(យ៉ាងតិចចំនួន១០ប័ណ្ណ)ឬទេ?",
				"ShortName" => "pv_card",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 3,
				"Visible" => true
			],[
				"AttributeName" => "តើមានសៀវភៅមគ្គុទេសក៍ជាតិព្យាបាលជំងឺគ្រុនចាញ់ ២០២២ ឬឯកសារជំនួយស្មារតីស្តីពីកម្រិតនៃការព្យាបាលដោយថ្នាំ ASMQ ថ្នាំPYRAMAX និងការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ វីវ៉ាក់ឬទេ? (លក្ខខណ្ឌត្រូវមានទាំងអស់)",
				"ShortName" => "pv_quideline",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 4,
				"Visible" => true
			],[
				"AttributeName" => "តើមានសម្ភារៈជំនួយស្មារតី សម្រាប់ការប្រមូលសំណាក និងការបកស្រាយលទ្ធផល SD G6PD BIOSENSOR ឬទេ?",
				"ShortName" => "support_material_collection",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 5,
				"Visible" => true
			],[
				"AttributeName" => "តើឧបករណ៍វិភាគ G6PD BIOSENSOR នៅដំណើរការឬទេ?",
				"ShortName" => "g6pd_tool_work",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 6,
				"Visible" => true
			],[
				"AttributeName" => "តើមានបន្ទះតេស្ត G6PD និងតេស្ដត្រួតពិនិត្យគុណភាពយ៉ាងតិច៥ មិនផុតកំណត់នៅខែបន្ទាប់ឬទេ?",
				"ShortName" => "g6pd_good",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 7,
				"Visible" => true
			],[
				"AttributeName" => "តើឧបករណ៍ HEMOCUE សម្រាប់ធ្វើតេស្តកម្រិតអេម៉ូក្លូប៊ីននៅដំណើរការឬទេ? (សូមរំលង បើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)",
				"ShortName" => "hemocue_tool_work",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 8,
				"Visible" => true
			],[
				"AttributeName" => "តើមានតេស្តពិនិត្យរកស្រ្តីមានគភ៌ឬទេ?(សូមរំលង បើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)",
				"ShortName" => "pregnancy_tool_work",
				"Section" => "1-2",
				"DataType" => "int",
				"Sort" => 9,
				"Visible" => true
			],
			//section 1-3
			[
				"AttributeName" => "តើគ្រប់ករណីជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ទាំងអស់ ត្រូវបានកត់ត្រាក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដG6PDនិងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ឬទេ?",
				"ShortName" => "pv_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 1,
				"Visible" => true
			],[
				"AttributeName" => "តើមានព័ត៌មាន ឬទិន្នន័យគ្រប់គ្រាន់ ក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ឬទេ.(លើកលែងករណីកំពុងតាមដាន)? (ត្រូវតែកត់ត្រាគ្រប់ព័ត៌មានទាំងអស់និងរំលងទីសំណួរទី៨ បើគ្មានករណីជំងឺគ្រុនចាញ់វីវ៉ាក់)",
				"ShortName" => "appropriate_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 2,
				"Visible" => true
			],[
				"AttributeName" => "តើចំនួនករណីទាំងអស់ ដែលកត់ត្រានៅក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់កត់ត្រាប្រចាំខែ និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់ (MIS) ដូចគ្នាឬទេ?",
				"ShortName" => "cases_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 3,
				"Visible" => true
			],[
				"AttributeName" => "តើគ្រប់លទ្ធផលG6PD ដែលកត់ត្រានៅក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់កត់ត្រាប្រចាំខែ និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់ (MIS) ដូចគ្នាឬទេ?",
				"ShortName" => "g6pd_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 4,
				"Visible" => true
			],[
				"AttributeName" => "តើចំនួនករណីជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ដែលបានព្យាបាលប្រចាំខែ ដែលកត់ត្រានៅក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដG6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់កត់ត្រាប្រចាំខែ និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)ដូចគ្នាឬទេ?",
				"ShortName" => "malaria_treat_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 5,
				"Visible" => true
			],[
				"AttributeName" => "តើគ្រប់ករណីជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ បញ្ចប់ការព្យាបាល កត់ត្រាក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ ប្រចាំខែ និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)  ដូចគ្នាឬទេ?",
				"ShortName" => "pv_compoleted_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 6,
				"Visible" => true
			],[
				"AttributeName" => "តើគ្រប់ផលរំខានឱសថ ដែលកត់ត្រានៅក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់កត់ត្រាប្រចាំខែ និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)  ដូចគ្នាឬទេ?",
				"ShortName" => "sideeffect_in_g6pd",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 7,
				"Visible" => true
			],[
				"AttributeName" => "តើចំនួនស្តុក ASMQ ដែលមាននៅក្នុងឃ្លាំងឱសថមូលដ្ឋានសុខាភិបាល និងក្នុង ប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)  ដូចគ្នាឬទេ?",
				"ShortName" => "asmq_enought",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 8,
				"Visible" => true
			],[
				"AttributeName" => "តើចំនួនស្តុក ព្រីម៉ាគីន៧.៥ ម.ក្រ ដែលមាននៅក្នុងឃ្លាំងឱសថមូលដ្ឋានសុខាភិបាល និងក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)ដូចគ្នាឬទេ?",
				"ShortName" => "primaquine_enought",
				"Section" => "1-3",
				"DataType" => "int",
				"Sort" => 9,
				"Visible" => true
			],
			//2-1

            [
                "AttributeName" => "តើបានពិនិត្យថ្ងៃខែឆ្នាំផុតកំណត់របស់ តេស្តរហ័ស (RDT)ដែរឬទេ?",
                "ShortName" => "see_rdt_expirydate",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានពាក់ស្រោមដៃឬទេ?",
                "ShortName" => "use_glove",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានកត់ត្រាកាលបរិច្ឆេទការធ្វើតេស្ត និងលេខកូដ របស់អ្នកជំងឺនៅលើខ្នងរបស់បន្ទះតេស្ដរហ័សឬទេ?",
                "ShortName" => "note_on_rdt",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានជូតចុងម្រាមដៃរបស់អ្នកជំងឺដោយសំឡីអាកុលឬទេ?",
                "ShortName" => "clean_finger",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានចាក់ចុងម្រាមដៃរបស់អ្នកជំងឺ និងបោះចោលម្ជុលដែលប្រើរួចចូលក្នុងប្រអប់សុវត្ថិភាពឬទេ?",
                "ShortName" => "throw_in_box",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានប្រើបំពង់យកឈាម ៥ មីក្រូលីត្រដើម្បីប្រមូលសំណាក និងដាក់ដំណក់ឈាមក្នុងកន្លែងដាក់សំណាក     រួចបោះចោលក្នុងប្រអប់សុវត្ថិភាពដែរឬទេ?",
                "ShortName" => "use_blood_typ",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 6,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានប្រើទឹកប្រតិករ (BUFFER)ចំនួន ៤ ដំណក់នៅកន្លែងដាក់សំណាកដែរឬទេ?",
                "ShortName" => "use_buffer",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 7,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានរង់ចាំចំនួន ១៥ នាទីដើម្បីទទួលបានលទ្ធផលដែរឬទេ?",
                "ShortName" => "wait_15mn",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 8,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានកត់ត្រាលទ្ធផលតេស្ត នៅលើតេស្ដរហ័ស និងសៀវភៅសម្រង់ទិន្នន័យជំងឺគ្រុនចាញ់ប្រចាំខែមណ្ឌលសុខភាព ដែរឬទេ?",
                "ShortName" => "note_test",
                "Section" => "2-1-1",
                "DataType" => "int",
                "Sort" => 9,
                "Visible" => true
            ],[
                "AttributeName" => "ឈ្មោះ ៖....",
                "ShortName" => "staff_name",
                "Section" => "2-1-1",
                "DataType" => "nvarchar",
                "Sort" => 9,
                "Visible" => true
            ],
			//2-1-2

            [
                "AttributeName" => "តើបានពាក់ស្រោមដៃដែរឬទេ?",
                "ShortName" => "use_glove",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "តើមានពិនិត្យកាលបរិច្ឆេទផុតកំណត់នៃឧបករណ៍ធ្វើតេស្តដែរឬទេ",
                "ShortName" => "see_expirydate",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "តើមានពិនិត្យថាតើលេខកូដឈីបនៅលើអេក្រង់ឧបករណ៍វិភាគត្រូវនឹងលេខកូដបន្ទះឈីបរបស់ឧបករណ៍ ដែរឬទេ?",
                "ShortName" => "see_screen",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានរៀបចំសម្ភារៈដែលត្រូវការទាំងអស់នៅលើតុមុនពេលចាប់ផ្តើមធ្វើតេស្តដែរឬទេ?",
                "ShortName" => "prepare",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានបញ្ចូលឧបករណ៍ធ្វើតេស្តទៅក្នុង ឧបករណ៍វិភាគ រួចបើកសន្ទះឧបករណ៍វិភាគ “OPE” ដែរឬទេ?",
                "ShortName" => "ope",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានពិនិត្យកាលបរិច្ឆេទផុតកំណត់ទឹកប្រតិករ បើកសន្ទះ និងទុកដាក់នៅកន្លែងដែលមានផ្ទៃរាបស្មើដែរឬទេ?",
                "ShortName" => "see_expirydate_6",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 6,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានសម្អាតចុងម្រាមដៃរបស់អ្នកជំងឺ នៅជុំវិញកន្លែងប្រមូលយកសំណាកដោយសំឡីអាកុលដែរឬទេ?",
                "ShortName" => "clean_finger_7",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 7,
                "Visible" => true
            ],[
                "AttributeName" => "តើដំណក់ឈាមដំបូងត្រូវបានជូតចេញដោយសំឡីស្ងួត ដែរឬទេ?",
                "ShortName" => "first_blood",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 8,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានប្រមូលឈាមពីចុងម្រាមដៃដែលត្រូវបានចាក់ ដល់បន្ទាត់ខ្មៅនៃបំពង់EZI ដែរឬទេ?",
                "ShortName" => "ezi",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 9,
                "Visible" => true
            ],[
                "AttributeName" => "តើដំណក់ឈាម និងទឹកប្រតិករបានលាយបញ្ចូលគ្នាបានល្អ ដោយច្របាច់បំពង់ EZI ៨-១០ ដងដែរឬទេ?",
                "ShortName" => "ezi_reactive",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 10,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានប្រើបំពង់ EZI ថ្មីមួយទៀតដើម្បីយកសំណាកដែលបានលាយរួច ហើយដាក់ចូលទៅក្នុងប្រហោងនៃឧបករណ៍ធើ្វតេស្តដែរឬទេ?",
                "ShortName" => "ezi_typ",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 11,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានបិទសន្ទះឧបករណ៍វិភាគ ហើយរង់ចាំលទ្ធផលតេស្ត “CLO”?",
                "ShortName" => "clo",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 12,
                "Visible" => true
            ],[
                "AttributeName" => "តើកាកសំណល់វេជ្ជសាស្រ្តដែលប្រើរួច បានវេចខ្ចប់ត្រឹមត្រូវក្នុងប្រអប់សុវត្ថិភាពដែរឬទេ?",
                "ShortName" => "wast",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 13,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានកត់ត្រាលទ្ធផល G6PD និងអេម៉ូក្លូប៊ីន បានត្រឹមត្រូវដែរឬទេ?",
                "ShortName" => "note_g6pd_hemo",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 14,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានបកស្រាយលទ្ធផលពីកំហុសបច្ចេកទេសដែលបានកើតឡើង ឬយល់ដឹងពីវិធីសាស្រ្តដើម្បីកែប្រែកំហុសទាំងនោះដែរឬទេ?",
                "ShortName" => "result_error",
                "Section" => "2-1-2",
                "DataType" => "int",
                "Sort" => 15,
                "Visible" => true
            ],
			[
                "AttributeName" => "ឈ្មោះ ៖..............",
                "ShortName" => "staff_name",
                "Section" => "2-1-2",
                "DataType" => "nvarchar",
                "Sort" => 15,
                "Visible" => true
            ],
			//2-2-3

            [
                "AttributeName" => "តើបានបើកឧបករណ៍វិភាគHEMOCUE និងពិនិត្យកាលបរិច្ឆេទផុតកំណត់មីក្រូគុយវ៉ែត(MICROCUVETTE )ដែរឬទេ?",
                "ShortName" => "use_hemocue",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានសម្អាតចុងម្រាមដៃរបស់អ្នកជំងឺ ជោះឈាម និងជូតដំណក់ឈាមដំបូងដោយសំឡីស្ងួតដែរឬទេ?",
                "ShortName" => "clean_finger",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានយកមីក្រូគុយវ៉ែតមួយមកប្រើ និងប្រមូលសំណាកឈាមរហូតដល់បន្ទាត់ដែលបានកំណត់ដែរឬទេ?",
                "ShortName" => "microcue",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានជូតសម្អាតចុងម្រាមដៃរបស់អ្នកជំងឺ និងត្រូវធានាថាគ្មានដំណក់ឈាមស្ថិតនៅក្រៅមីក្រូគុយវ៉ែតដែរឬទេ?",
                "ShortName" => "clean_finger_2_1_3",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានដាក់សំណាកចូលក្នុងឧបករណ៍វិភាគ និងបិទបន្ទះវិភាគដែរឬទេ?",
                "ShortName" => "analyze",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានបកប្រែលទ្ធផល និងកត់ត្រាលទ្ធផលបានត្រឹមត្រូវដែរឬទេ?",
                "ShortName" => "result",
                "Section" => "2-1-3",
                "DataType" => "int",
                "Sort" => 6,
                "Visible" => true
            ],[
                "AttributeName" => "ឈ្មោះ ៖..........",
                "ShortName" => "staff_name",
                "Section" => "2-1-3",
                "DataType" => "nvarchar",
                "Sort" => 6,
                "Visible" => true
            ],
			//2-1-4
			[
                "AttributeName" => "តើបានពិនិត្យកាលបរិច្ឆេទផុតកំណត់របស់តេស្តពិនិត្យរកស្រ្តីមានគភ៌ដែរឬទេ?",
                "ShortName" => "see_expirydate_pregnacy",
                "Section" => "2-1-4",
                "DataType" => "int",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានប្រមូលសំណាកទឹកមូត្រពីអ្នកជំងឺដែរឬទេ?",
                "ShortName" => "urinate",
                "Section" => "2-1-4",
                "DataType" => "int",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានយកបំពង់បឺតទឹកមូត្រចំនួន ៣ ដំណក់ដាក់ចូលកន្លែងដាក់សំណាកដែរឬទេ?",
                "ShortName" => "urinate_type",
                "Section" => "2-1-4",
                "DataType" => "int",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានរង់ចាំចំនួន  ៣ នាទី ដើម្បីទទួលបានលទ្ធផលដែរឬទេ?",
                "ShortName" => "wait3min",
                "Section" => "2-1-4",
                "DataType" => "int",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "តើបានបកស្រាយលទ្ធផល និងកត់ត្រាលទ្ធផលបានត្រឹមត្រូវដែរឬទេ?",
                "ShortName" => "result",
                "Section" => "2-1-4",
                "DataType" => "int",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "ឈ្មោះ ៖...............",
                "ShortName" => "staff_name",
                "Section" => "2-1-4",
                "DataType" => "nvarchar",
                "Sort" => 5,
                "Visible" => true
            ],
			//3-1-1
			[
                "AttributeName" => "បុរស អាយុ ២៥ ឆ្នាំ មានទម្ងន់ ៦០គីឡូ លទ្ធផលតេស្ដG6PD = ៨.៦ និង អេម៉ូក្លូប៊ីន (Hb)= ៩",
                "ShortName" => "men28",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ២៨ ឆ្នាំ មានទម្ងន់៥៤គីឡូ G6PD= ៥.៣ អេម៉ូក្លូប៊ីន (Hb) = ១៦.៥",
                "ShortName" => "woman28",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ១០ ខែ មានទម្ងន់ 9គីឡូ G6PD= ៦.៨ អេម៉ូក្លូប៊ីន (Hb) = ១៥",
                "ShortName" => "woman10",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "បុរស អាយុ ៥ ឆ្នាំ មានទម្ងន់ ១៨គីឡូ G6PD= ១.២០ អេម៉ូក្លូប៊ីន (Hb) = ៨",
                "ShortName" => "man5",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ២១ ឆ្នាំ មានទម្ងន់ ៣៦គីឡូ G6PD= ៩.៣ អេម៉ូក្លូប៊ីន (Hb)= ៥ ",
                "ShortName" => "woman21_36kg",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "បុរស អាយុ ១៤ ឆ្នាំ មានទម្ងន់ ៣៩គីឡូ G6PD= ៤.៤ អេម៉ូក្លូប៊ីន (Hb) = ១៦.៣",
                "ShortName" => "man14",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 6,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ៩ ឆ្នាំ មានទម្ងន់ ២០ គីឡូ G6PD ៦.១ អេម៉ូក្លូប៊ីន (Hb)= ១១.៣",
                "ShortName" => "woman9",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 7,
                "Visible" => true
            ],[
                "AttributeName" => "បុរស អាយុ ១៣ ឆ្នាំ មានទម្ងន់ ៣២ គីឡូ G6PD ០.៨០ អេម៉ូក្លូប៊ីន (Hb)=១៦.៧០",
                "ShortName" => "man13",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 8,
                "Visible" => true
            ],[
                "AttributeName" => "បុរស អាយុ ៦២ ឆ្នាំ មានទម្ងន់ ៦០ គីឡូ G6PD = E-2 អេម៉ូក្លូប៊ីន (Hb)= ១៤.៨",
                "ShortName" => "man62",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 9,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ១៤ ឆ្នាំ មានទម្ងន់ ៣៣ គីឡូ G6PD = E-4 អេម៉ូក្លូប៊ីន (Hb)= ១១.៨",
                "ShortName" => "woman14",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 10,
                "Visible" => true
            ],[
                "AttributeName" => "ស្រ្តី អាយុ ២៧ ឆ្នាំ មានទម្ងន់ ៤៩គីឡូ បំបៅដោះកូន",
                "ShortName" => "woman27",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 11,
                "Visible" => true
            ],[
                "AttributeName" => "អ្នកជំងឺបានមកដល់មណ្ឌលសុខភាពដើម្បីធ្វើតេស្ត G6PD ក្រោយពីបានធ្វើតេស្ត និងបញ្ចប់ការលេបថ្នាំ ACT ចំនួន ៥ ថ្ងៃ (បុរស អាយុ ២៨ ឆ្នាំ មានទម្ងន់ ៥០គីឡូ G6PD= ៣.៣ អេម៉ូក្លូប៊ីន (Hb)= ១០.៣)",
                "ShortName" => "patient_test_g6pd",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 12,
                "Visible" => true
            ],[
                "AttributeName" => "អ្នកជំងឺបានមកដល់មណ្ឌលសុខភាពដើម្បីធ្វើតេស្ត G6PD ក្រោយពីបានធ្វើតេស្ត និងបញ្ចប់ការលេបថ្នាំ ACT ចំនួន ២ ថ្ងៃ(
                បុរស អាយុ ៣៣ ឆ្នាំ មានទម្ងន់ ៥៥ គីឡូ G6PD= ៦.៣ អេម៉ូក្លូប៊ីន (Hb)= ១១.៥)
                ",
                "ShortName" => "test_g6pd_2d",
                "Section" => "3-1-1",
                "DataType" => "object",
                "Sort" => 13,
                "Visible" => true
            ],
            //4-1-1
            [
                "AttributeName" => "តើគ្រប់អ្នកជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ដែលទទួលការព្យាបាលផ្តាច់ត្រូវបានផ្តល់ប័ណ្ណព័ត៌មាន និងប្រឹក្សាដោយយោងទៅតាមលទ្ធផលរបស់ G6PD របស់អ្នកជំងឺដែរឬទេ?",
                "ShortName" => "malaria_mgm",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 1,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់អ្នកជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ ដែលទទួលការព្យាបាលផ្តាច់ត្រូវបានទំនាក់ទំនងដើម្បីតាមដាន (សុវត្ថិភាព ការលេបថ្នាំទៀងទាត់ និងគ្រប់ចំនួន) ដោយមន្ត្រីមណ្ឌលសុខភាព ឬអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ ទៅតាមថ្ងៃកំណត់ដែរឬទេ?",
                "ShortName" => "pv_mgm",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 2,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់មន្ត្រីមូលដ្ឋានសុខាភិបាលដែលទទួលបន្ទុកការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ អាចរៀបរាប់រោគសញ្ញា/អាការៈ របស់ផលរំខានឱសថព្រីម៉ាគីនបានចំនួន ៥ ដែរឬទេ? (ត្រូវរាប់សញ្ញាផលរំខានទាំង៥)",
                "ShortName" => "staff_mgm",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 3,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់ទិន្នន័យបានកត់ត្រានៅក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់របស់មូលដ្ឋានសុខាភិបាល ឬ អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ដែរឬទេ? (សូមរំលងប្រសិនបើគ្មានករណី)",
                "ShortName" => "data_in_book",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 4,
                "Visible" => true
            ],[
                "AttributeName" => "តើទិន្នន័យតាមដានការព្យាបាលផ្តាច់នៅលើក្រដាស(សម្រាប់អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ និងប្រព័ន្ធព័ត៌មានជំងឺគ្រុនចាញ់ ដូចគ្នាដែរឬទេ? (សូមរំលងប្រសិនបើគ្មានករណី)",
                "ShortName" => "followup_data",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 5,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់អ្នកជំងឺដែលបានរាយការណ៍ពីរោគសញ្ញា/អាការៈត្រូវបានបញ្ជូនទៅកាន់មន្ទីរពេទ្យដើម្បីវាយតម្លៃ និងបំពេញទម្រង់របស់នាយកដ្ឋានឱសថ (DDF) ដែរឬទេ? (សូមរំលងប្រសិនបើគ្មានករណី)",
                "ShortName" => "patient_reported",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 6,
                "Visible" => true
            ],[
                "AttributeName" => "តើអនុប្រធានម.គ.ច បានទទួលការផ្តល់ដំណឹងភ្លាមៗគ្រប់ករណីអ្នកជំងឺសង្ស័យមានរោគសញ្ញា/អាការៈនៃផលរំខានដោយប្រើប្រាស់ឱសថព្រីម៉ាគីនដែរឬទេ?(លក្ខខណ្ឌ៖ បើគ្មានផលរំខាន មិនបូកពិន្ទុបញ្ចូលទេ  និងសូមរំលងប្រសិនបើគ្មានករណី)",
                "ShortName" => "viced_cnm",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 7,
                "Visible" => true
            ],[
                "AttributeName" => "តើករណីតាមដានការព្យាបាលផ្តាច់នៅលើក្រដាស និងក្នុងប្រព័ន្ធព័ត៌មានជំងឺគ្រុនចាញ់ (MIS)ដូចគ្នាដែរឬទេ?(សូមរំលង ប្រសិនបើមិនធ្លាប់ទទួលបានការបណ្តុះបណ្តាលស្តីពីការរាយការណ៍     ផលរំខាននៃការប្រើប្រាស់ឱសថ។ លក្ខខណ្ឌ៖ មិនបូកពិន្ទុបញ្ចូលទេ)",
                "ShortName" => "followup_paper",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 8,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់ករណីអ្នកជំងឺសង្ស័យមានរោគសញ្ញា/អាការៈនៃផលរំខានដោយប្រើប្រាស់ឱសថព្រីម៉ាគីន ត្រូវបានបញ្ជូនទៅកាន់មន្ទីរពេទ្យសម្រាប់វាយតម្លៃផលរំខាននៃការប្រើប្រាស់ឱសថដែរឬទេ?(សូមរំលង ប្រសិនបើមិនធ្លាប់ទទួលបានការបណ្តុះបណ្តាលស្តីពីការរាយការណ៍     ផលរំខាននៃការប្រើប្រាស់ឱសថ។ លក្ខខណ្ឌ៖ មិនបូកពិន្ទុបញ្ចូលទេ)",
                "ShortName" => "suspect_pq",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 9,
                "Visible" => true
            ],[
                "AttributeName" => "តើគ្រប់ករណីអ្នកជំងឺមានរោគសញ្ញា/អាការៈនៃផលរំខានដោយប្រើប្រាស់ឱសថព្រីម៉ាគីនដែលត្រូវស្នាក់នៅមន្ទីរពេទ្យខេត្ត បានបំពេញទម្រង់ផលរំខាននៃការប្រើប្រាស់ឱសថព្រីម៉ាគីន និងបានដាក់ពាក្យស្នើសុំប្រាក់ទូទាត់សម្រាប់ថ្លៃសេវាមន្ទីរពេទ្យដែរឬទេ?(សូមរំលង ប្រសិនបើមិនធ្លាប់ទទួលបានការបណ្តុះបណ្តាលស្តីពីការរាយការណ៍     ផលរំខាននៃការប្រើប្រាស់ឱសថ។ លក្ខខណ្ឌ៖ មិនបូកពិន្ទុបញ្ចូលទេ)",
                "ShortName" => "call_symptom",
                "Section" => "4-1-1",
                "DataType" => "int",
                "Sort" => 10,
                "Visible" => true
            ]
		];
    }
}