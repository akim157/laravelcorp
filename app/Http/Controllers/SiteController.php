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
    protected $c_rep; //сохранения логики с работай комментариев
    protected $template; //сохранения имя шаблона
    protected $vars = array(); //массив передаваемый данных для шаблона
    protected $bar = 'no'; //sitebar по умолчанию его нет.
    protected $contentRightBar = false; //свойство для хранения информации для правого sitebar
    protected $contentLeftBar = false; //свойство для хранения информации для левого sitebar

    protected $keywords;
    protected $meta_desc;
    protected $title;
    
    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }
    
    protected function renderOutput() 
    {
        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        if($this->contentRightBar) {
            $rightBar = view(env('THEME') . '.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }
        if($this->contentLeftBar) {
            $leftBar = view(env('THEME') . '.leftBar')->with('content_leftBar', $this->contentLeftBar)->render();
            $this->vars = array_add($this->vars, 'leftBar', $leftBar);
        }
        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $footer = view(env('THEME') . '.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu()
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