<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Menu;

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
    
    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }
    
    protected function renderOutput() 
    {
        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();
        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            foreach($menu as $item) {
                if($item->parent == 0)
                {
                    $m->add($item->title, $item->path)->id($item->id);
                }
                else
                {
                    if($m->find($item->parent))
                    {
                        $m->find($item->parent)->add($item->title, $item->path)->id();
                    }
                }
            }
        });
        return $mBuilder;
    }
}