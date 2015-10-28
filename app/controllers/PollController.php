<?php

use Auditor\Repositories\PollRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Managers\PollManager;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\PollDetailRepo;
//use Auditor\Managers\PollDetailManager;
use Auditor\Managers\PollOptionDetailManager;


class PollController extends BaseController {

    protected $pollRepo;
    protected $CompanyAuditRepo;
    protected $pollOptionRepo;
    protected $pollOptionDetailRepo;
    protected $pollDetailRepo;

    public function __construct(PollDetailRepo $pollDetailRepo, PollRepo $pollRepo, CompanyAuditRepo $CompanyAuditRepo, PollOptionRepo $pollOptionRepo, PollOptionDetailRepo $pollOptionDetailRepo)
    {
        $this->pollRepo = $pollRepo;
        $this->CompanyAuditRepo = $CompanyAuditRepo;
        $this->pollOptionRepo = $pollOptionRepo;
        $this->pollOptionDetailRepo = $pollOptionDetailRepo;
        $this->pollDetailRepo = $pollDetailRepo;
    }

    public function insertPoll()
    {
        $listcomp= $this->getCompanies();

        $combobox = array(0 => "--- Seleccione una empresa --- ") + $listcomp;

        $company_id= Input::only('company');

        //dd($company_id['company_id']);
        if ($company_id['company']<>null){
            $companyObject = New CompanyRepo;

            $company = $companyObject->getNameCompany($company_id['company']);

            $questions = $this->pollRepo->getQuestions($company_id['company']);
            //dd($questions);
            $selected = array();
        }else{
            $selected = array();
        }
        return View::make('audits/confPolls',compact('combobox','selected','questions', 'company'));
    }

    public function registerPoll()
    {
        $poll = $this->pollRepo->newPoll();
        //dd($poll);
        //dd(Input::all());
        $manager = new PollManager($poll, Input::all());
        $company_id=Input::only('company_id');
        $manager->save();
        //return Redirect::route('listCompanies');
        return Redirect::route('insertPoll',"company=".$company_id['company_id']);

    }

    public function responsePoll($company_id,$audit_id,$store_id,$mensaje="")
    {
        $userType = Auth::user()->type;
        $polls = $this->pollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id));
        if (count($polls) > 0) {
            foreach ($polls as $poll) {
                if ($poll->sino==1) {
                    if ($poll->id==38){
                        $sinoPoll[] = array('sino' => 2, 'val'=>'Afiches');
                        $sinoPoll[] = array('sino' => 3, 'val'=>'Afiche plástico');
                        $sinoPoll[] = array('sino' => 4, 'val'=>'Letreros');
                    }else{
                        $sinoPoll[] = array('sino' => 0, 'val'=>'No');
                        $sinoPoll[] = array('sino' => 1, 'val'=>'Si');
                    }

                }else{
                    $sinoPoll = array('sino' => '', 'val'=>'');
                }
                if ($poll->options==1) {
                    $options = $this->pollOptionRepo->getOptions($poll->id);
                    //dd($options);
                    if (count($options)>0){
                        foreach ($options as $option) {
                            if ($poll->id==32){
                                if ($store_id==1244){
                                    if (($option->id>=67) and ($option->id<=72))
                                    {
                                        $optionsPoll[] = array('option_id'=> $option->id,'option'=>$option->options);
                                    }
                                }
                                if ($store_id==1245){
                                    if (($option->id>=148) and ($option->id<=149))
                                    {
                                        $optionsPoll[] = array('option_id'=> $option->id,'option'=>$option->options);
                                    }
                                }
                                if ($store_id==1246){
                                    if (($option->id>=150) and ($option->id<=156))
                                    {
                                        $optionsPoll[] = array('option_id'=> $option->id,'option'=>$option->options);
                                    }
                                }
                            }else{
                                $optionsPoll[] = array('option_id'=> $option->id,'option'=>$option->options);
                            }

                        }
                    }else{
                        $optionsPoll[] = array('option_id'=> 0,'option'=>0);
                    }
                }else{
                    $optionsPoll[] = array('option_id'=> 0,'option'=>0);
                }


                //dd($optionsPoll);
                $questionsOptions[] = array('poll_id' => $poll->id,'question' => $poll->question,'sino'=> $poll->sino,'options'=>$poll->options,'valSino' => $sinoPoll, 'valOptions' => $optionsPoll);
                unset($optionsPoll);
                unset($sinoPoll);
            }
            //dd($questionsOptions);
        }
        return View::make('auditors/insertPollMediaConcept',compact('questionsOptions','userType','company_id','audit_id','store_id','mensaje'));


    }

    public function insertResponsePoll()
    {
        //dd(Input::all());
        $auditor = Auth::user()->id;
        $audit_id = Input::only('audit_id');
        $company_id = Input::only('company_id');
        $store_id = Input::only('store_id');
        $polls = $this->pollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id['audit_id'],$company_id['company_id']));
        if (count($polls) > 0) {
            foreach ($polls as $poll) {
                $pollDetail = $this->pollDetailRepo->getModel();
                $pollDetail->auditor = $auditor;
                $pollDetail->poll_id = $poll->id;
                $pollDetail->store_id = 0;
                if ($poll->sino==1) {
                    $valsino = Input::only('sino-'.$poll->id);
                    if ($valsino['sino-'.$poll->id]<>""){
                        $pollDetail->sino = 1;
                        $pollDetail->result = $valsino['sino-'.$poll->id];
                    }
                }else{
                    $pollDetail->result = 0;
                }
                $pollDetail->limits =0;
                $pollDetail->media=0;
                $pollDetail->coment =0;
                $pollDetail->limite ="";
                $pollDetail->comentario = "";
                $pollDetail->comentOptions = 0;
                $pollDetail->store_id=$store_id['store_id'];
                if ($poll->options==1){
                    $valoption = Input::only('option-'.$poll->id);
                    if (isset($valoption['option-'.$poll->id])){
                        if ($valoption['option-'.$poll->id]<>""){
                            $pollDetail->options = 1;
                            $options = $this->pollOptionRepo->getOptions($poll->id);
                            if (count($options)>0){
                                foreach ($options as $option) {
                                    $valoption = Input::only('option-'.$option->id);
                                    if (isset($valoption['option-'.$option->id])){
                                        if ($valoption['option-'.$option->id] == $option->id)
                                        {
                                            $pollOptionDetail= $this->pollOptionDetailRepo->getModel();
                                            $pollOptionDetail->auditor = $auditor;
                                            $pollOptionDetail->poll_option_id = $valoption['option-'.$option->id];
                                            $pollOptionDetail->result = 1;
                                            $pollOptionDetail->store_id = $store_id['store_id'];
                                            $pollOptionDetail->save();
                                        }
                                    }
                                }
                            }

                        }
                    }
                }else{
                    $pollDetail->options =0;
                }
                $pollDetail->save();
            }
        }
        $mensaje="Cuestionario ingresado con exito";
        return $this->responsePoll($company_id['company_id'],$audit_id['audit_id'],$store_id['store_id'],$mensaje);
    }

} 