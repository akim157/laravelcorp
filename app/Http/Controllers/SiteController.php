<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    //

    protected $p_rep; //сохранения логики с работай портфолио
    protected $s_rep; //сохранения логики с работай слайдер
    protected $a_rep; //сохранения логики с работай статьями
    protected $m_rep; //сохранения логики с работай меню
    protected $template; //сохранения имя шаблона
    protected $vars = array(); //массив передаваемый данных для шаблона
    protected $bar = false; //sitebar по умолчанию его нет.
    protected $contentRightBar = false; //свойство для хранения информации для правого sitebar
    protected $contentLeftBar = false; //свойство для хранения информации для левого sitebar
    
    public function __construct()
    {
        
    }
    
    protected function renderOutput() 
    {
        return view($this->template)->with($this->vars);
    }
}