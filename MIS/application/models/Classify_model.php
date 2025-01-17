<?php

class Classify_model extends CI_Model
{
	public function update($data)
	{
        if(!isset($data['Classify'])) return;
        if(isset($data['LAType'])) {
            $classify['Indigneous'] = $data['LAType'] == 'Indigneous' && $data['Classify'] == 'LocallyAcquired' ? 1 : 0;
            $classify['Introduced'] = $data['LAType'] == 'Introduced' && $data['Classify'] == 'LocallyAcquired' ? 1 : 0;
        }

        if( $data['Classify'] == 'LocallyAcquired' ) {
            $classify['L1'] = 1;
            $classify['LC'] = null;
            $classify['IMP'] = null;
            $classify['Relapse'] = null;
            $classify['Induce'] = null;

            //$classify['LocallyAcquired'] = 1;
            //$classify['DomesticallyImported'] = null;
            //$classify['InternationalImported'] = null;
        }
        else if ( $data['Classify'] == 'DomesticallyImported' ) {
            $classify['L1'] = null;
            $classify['LC'] = 1;
            $classify['IMP'] = null;
            $classify['Relapse'] = null;
            $classify['Induce'] = null;

            //$classify['LocallyAcquired'] = null;
            //$classify['DomesticallyImported'] = 1;
            //$classify['InternationalImported'] = null;
        }
        else if ( $data['Classify'] == 'InternationalImported' ) {
            $classify['L1'] = null;
            $classify['LC'] = null;
            $classify['IMP'] = 1;
            $classify['Relapse'] = null;
            $classify['Induce'] = null;

            //$classify['LocallyAcquired'] = null;
            //$classify['DomesticallyImported'] = null;
            //$classify['InternationalImported'] = 1;
        }
        else if ( $data['Classify'] == 'Relapse' ) {
            $classify['L1'] = null;
            $classify['LC'] = null;
            $classify['IMP'] = null;
            $classify['Relapse'] = 1;
            $classify['Induce'] = null;

            //$classify['LocallyAcquired'] = null;
            //$classify['DomesticallyImported'] = null;
            //$classify['InternationalImported'] = null;
        }
        else if ( $data['Classify'] == 'Induce' ) {
            $classify['L1'] = null;
            $classify['LC'] = null;
            $classify['IMP'] = null;
            $classify['Relapse'] = null;
            $classify['Induce'] = 1;

            //$classify['LocallyAcquired'] = null;
            //$classify['DomesticallyImported'] = null;
            //$classify['InternationalImported'] = null;
        }

        if($data['Case_Type'] == 'HC')
		    $this->db->update('tblHFActivityCases',$classify, ['Rec_ID' => $data['Case_ID']]);
        else
            $this->db->update('tblVMWActivityCases',$classify, ['Rec_ID' => $data['Case_ID']]);
	}

    public function updateDel($data) {
        $classify['L1'] = 0;
        $classify['Indigneous'] =  0;
        $classify['Introduced'] = 0;
        $classify['LC'] =  0;
        $classify['IMP'] =  0;
        $classify['Induce'] =  0;
        $classify['Relapse'] =  0;

        //$classify['LocallyAcquired'] = null;
        //$classify['DomesticallyImported'] = null;
        //$classify['InternationalImported'] = null;

        if($data['Case_Type'] == 'HC')
		    $this->db->update('tblHFActivityCases',$classify, ['Rec_ID' => $data['Case_ID']]);
        else
            $this->db->update('tblVMWActivityCases',$classify, ['Rec_ID' => $data['Case_ID']]);
    }
}