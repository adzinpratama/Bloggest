<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class AdminMenu extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data['menus'] = [
            '' => [
                [
                    'label' => trans('common.link.dashboard'),
                    'link' => route('dashboard'),
                    'active' => ['dashboard'],
                    'icon' => 'home',
                    'child' => false
                ]
            ],
            'BLOG' => [
                [
                    'label' => trans('common.link.post'),
                    'link' => route('post.index'),
                    'active' => ['post.index', 'post.create', 'post.edit'],
                    'icon' => 'book',
                    'child' => false,
                    // 'child' => [
                    //     [
                    //         'label' => 'List',
                    //         'link' => 'article/list',
                    //         'icon' => 'circle'
                    //     ],
                    //     [
                    //         'label' => 'Pages',
                    //         'link' => 'article/pages',
                    //         'icon' => 'circle'
                    //     ],
                    //     [
                    //         'label' => 'Draft',
                    //         'link' => 'article/draft',
                    //         'icon' => 'circle'
                    //     ]
                    // ]
                ],
                [
                    'label' => trans('common.link.filter'),
                    'link' => route('filter.index'),
                    'active' => ['filter.index'],
                    'icon' => 'filter',
                    'child' => false
                ],
                [
                    'label' => trans('common.link.category'),
                    'link' => route('category.index'),
                    'active' => ['category.index'],
                    'icon' => 'layers',
                    'child' => false
                ],
                [
                    'label' => trans('common.link.tag'),
                    'link' => route('tags.index'),
                    'active' => ['tags.index'],
                    'icon' => 'tag',
                    'child' => false
                ]
            ],
            trans('common.label.User_permission') => [
                [
                    'label' => trans('common.link.roles'),
                    'link' => '',
                    'active' => '',
                    'icon' => 'user',
                    'child' => false
                ],
                [
                    'label' => trans('common.link.user'),
                    'link' => '',
                    'active' => '',
                    'icon' => 'users',
                    'child' => false
                ],
            ],
            trans('common.label.setting') => [
                [
                    'label' => trans('common.link.file_manager'),
                    'link' => '',
                    'active' => '',
                    'icon' => 'save',
                    'child' => false
                ]
            ]
        ];
        return view('layouts._admin.menu', $data);
    }
}
