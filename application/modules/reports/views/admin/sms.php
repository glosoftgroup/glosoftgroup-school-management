<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report </h2> 
    <div class="right">                    
    </div> 					
</div>
<div class="toolbar">
    <div class="noof">
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <button class="btn btn-primary" name="preview" value="12" type="submit">Preview</button>
            &nbsp;
            <button class="btn btn-success" name="send" value="10" type="submit"  onClick="return confirm('Confirm Send SMS?')">Send SMS</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<?php
$i = 1;
if (isset($res['xload']) && isset($res['max']) && $subjects)
{
        $xload = $res['xload'];
        $maxw = $res['max'];
        foreach ($xload as $kla => $specs)
        {
                foreach ($specs as $str => $sp)
                {
                        aasort($sp, 'tots', TRUE);
                        $cl = isset($classes[$kla]) ? $classes[$kla] : ' - ';
                        $scl = isset($classes[$kla]) ? class_to_short($cl) : ' - ' . $kla;
                        $strr = isset($streams[$str]) ? $streams[$str] : ' - ' . $str;

                        $jj = 0;
                        $fav = array();
                        $ftos = array();
                        $spans = array();
                        foreach ($sp as $kky => $dd)
                        {
                                if (!isset($adm[$kky]))
                                {
                                        continue;
                                }
                                //$name = isset($adm[$kky]) ? $adm[$kky] : ' - ';
                                $name = $adm[$kky];
                                $messg = 'Hello Parent,  ' . $ex->title . ' - Term ' . $ex->term . '  ' . $ex->year . ' Results For ' . $name . ': ';

                                $tadd = 0;
                                $tott = 0;

                                foreach ($subjects as $ksub => $mkkd)
                                {
                                        $dts = (object) $mkkd;
                                        $hap = isset($dd['mks'][$ksub]) ? $dd['mks'][$ksub] : array();
                                        if (empty($hap))
                                        {
                                                continue;
                                        }
                                        $mkf = (object) $hap;

                                        $ksp = 0;
                                        $tott += $mkf->marks;

                                        $spans[$ksub] = $ksp;
                                        $fav[$ksub][$jj] = $mkf->marks;

                                        $rgd = $this->ion_auth->remarks($mkf->grading, $mkf->marks);
                                        $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : '';

                                        $messg .= ' ' . $dts->title . ':' . $mkf->marks . str_replace(' ', '', $hs_grade) . ' ';
                                }
                                $messg .= ' TOTAL: ' . $tott . ' POS. ' . $i . '/' . count($sp);
                                $message = str_replace('  ', ' ', str_replace(' / ', '/', $messg));

                                if ($this->input->post('send') && $this->input->post('send') == 10)
                                {
                                        $admss = $this->worker->get_student($kky);
                                        $parent = $this->portal_m->get_parent($admss->parent_id);
                                        $phone = $parent->phone;
                                        if (empty($phone))
                                        {
                                                $phone = $parent->mother_phone;
                                        }
                                        $this->sms_m->send_sms($phone, $message);
                                }
                                else if ($this->input->post('preview'))
                                {
                                        echo '<div class="quote">' . $message . '</div>';
                                }
                                else
                                {
                                        
                                }
                                $i++;
                                $jj++;
                        }
                }
        }
}
?>
<script>
        $(document).ready(function ()
        {
            $(".selecte").select2({'placeholder': 'Select Option', 'width': '200px'});
        });
</script>
<style>
    .fless{width:100%; border:0;}
    .quote:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        border-width: 0 3px 3px 0;
        border-style: solid;
        border-color: #658E15 #FFF;
        box-shadow: -3px 3px 5px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote:hover:before {
        border-width: 0 3rem 3rem 0;
        box-shadow: -6px 6px 5px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote {
        position: relative;
        width: 93%;
        padding: 1rem 1.6rem;
        margin: 2rem auto;
        font: italic 21px/1.4 Opensans, serif;
        color: #fff;
        background: #245991;
        border-radius: 1rem;
    }

    .quote:after {
        content: "";
        position: absolute;
        top: 100%;
        right: 25px;
        border-width: 10px 10px 0 0;
        border-style: solid;
        border-color: #245991 transparent;
    }
</style>