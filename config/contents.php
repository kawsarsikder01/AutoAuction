<?php
return [

    'hero' => [
        'single' => [
            'field_name' => [
                'heading'     => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea',
                'image'       => 'file',
            ],
            'validation' => [
                'heading.*'     => 'required | max:100',
                'sub_heading.*' => 'required | max:100',
                'description.*' => 'required | max:400',
                'image.*'       => 'nullable | max:5000 | image | mimes:jpg,jpeg,png',
            ]
        ]
    ],
    'features' => [
        'single' => [
            'field_name' => [
                'heading'     => 'text',
                'sub_heading' => 'text',
                'description' => 'textarea'
            ],
            'validation' => [
                'heading.*'     => 'required | max:40',
                'sub_heading.*' => 'required | max:40',
                'description.*' => 'nullable | max:250',
            ],
        ],
        'multiple' => [
            'field_name' => [
                'icon'    => 'text',
                'heading' => 'text',
                'text'    => 'textarea'
            ],
            'validation' => [
                'icon.*'    => 'required',
                'heading.*' => 'required | max:40',
                'text.*'    => 'required | max:200'
            ]
        ]
    ],
    'how_works' => [
            'single' => [
                'field_name' => [
                    'heading'     => 'text',
                    'sub_heading' => 'text',
                    'text'        => 'textarea',
                    'image'       => 'file'
                ] ,
                'validation' => [
                    'heading.*'     => 'required | max:50',
                    'sub_heading.*' => 'required | max:50',
                    'text.*'        => 'required | max:200',
                    'image.*'       => 'nullable | image | max:3072 | mimes:jpg,jpeg,png'
                ]
            ],
            'multiple' => [
                'field_name' => [
                    'heading' => 'text',
                    'text'    => 'textarea'
                ],
                'validation' => [
                    'heading.*' => 'required | max:50',
                    'text.*'    => 'required | max:200'

                ]
            ]
        ],
    'testimonial' => [
        'single' => [
            'field_name' => [
                'title'     => 'text',
                'sub_title' => 'text',
                'text'      => 'text',
                'image'     => 'file'
            ],
            'validation' => [
                'title.*'     => 'required | max:50',
                'sub_title.*' => 'required | max:60',
                'text.*'      => 'nullable | max:200',
                'image.*'     => 'nullable | max:3072 | image | mimes:jpg,jpeg,png'
                ]
            ],
        'multiple' => [
            'field_name' => [
                'name'  => 'text',
                'title' => 'text',
                'text'  => 'textarea',
                'image' => 'file'
            ],
            'validation' => [
                'name.*'  => 'required | max:30',
                'title.*' => 'required | max:40',
                'text.*'  => 'required | max:200',
                'image.*' => 'nullable | max:3072 | image | mimes:jpg,jpeg,png'
            ]
        ]
    ],
    'blog' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'description' =>'textarea'
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:100',
                'description.*' => 'required|max:400',
            ]
        ]
    ],
    'featured_inventory' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'description' =>'textarea'
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'sub_heading.*' => 'required|max:150',
                'description.*' => 'required|max:400',
            ]
        ]
    ],
    'brand' => [
        'multiple' => [
            'field_name' => [
                'image' => 'file'
            ],
            'validation' => [
                'image.*' => 'nullable | image | max:3072 | mimes:jpg,jpeg,png'
            ]
        ]
    ],
    'about' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'title'   => 'text',
                'description'  => 'textarea',
                'total_raised_amount' => 'number',
                'image' => 'file'
            ],
            'validation' => [
                'heading.*'             => 'required | max:50',
                'title.*'               => 'required | max:50',
                'description.*'         => 'required | max:2000',
                'total_raised_amount.*' => 'required ',
                'image.*'               => 'nullable | max:5000 | image | mimes:jpg,jpeg,png,avif'
            ]
        ],
        'multiple' => [
           'field_name' => [
            'option' => 'text',
           ],
           'validation' => [
               'option.*' => 'required|max:200'
           ]
        ]
    ],
    'achievement' => [
        'single' => [
            'field_name' => [
                'clients'           => 'number',
                'satisfaction_rate' => 'number',
                'sales_till_now'    => 'number',
                'years_on_industry' => 'number',
            ] ,
            'validation' => [
                'clients.*'           => 'required',
                'satisfaction_rate.*' => 'required',
                'sales_till_now.*'    => 'required',
                'years_on_industry.*' => 'required',
            ]
        ]
    ],
    'why_chose_us' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'title'   => 'text',
                'text'    => 'textarea',
            ],
            'validation' => [
                'heading.*' => 'required | max:50',
                'title.*'   => 'required | max:50',
                'text.*'    => 'required | max:200',
            ]
            ],
        'multiple' => [
            'field_name' => [
                'icon'    => 'text',
                'heading' => 'text',
                'text'    => 'textarea'
            ],
            'validation' => [
                'icon.*'    => 'required',
                'heading.*' => 'required | max:50',
                'text.*'    => 'required | max:200'
            ]
        ]
    ],
    'privacy_policy' => [
        'single' => [
            'field_name' => [
                'heading'   => 'text',
                'multitext' => 'textarea'
            ],
            'validation' => [
                'heading.*'   => 'required | max:50',
                'multitext.*' => 'required | max:300'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'heading' => 'text',
                'text'    => 'textarea',
            ],
            'validation' => [
                'heading.*' => 'required | max:50',
                'text.*'    => 'required | max:1000',
            ]
        ]
    ] ,
    'contact' => [
        'single' => [
            'field_name' => [
                'heading'     => 'text',
                'title'       => 'text',
                'description' => 'textarea',
                'email'       => 'text',
                'phone_no'    => 'number',
                'address'     => 'text',
                'map_url'     => 'text'
            ],
            'validation' => [
                'heading.*'     => 'required | max:50',
                'title.*'       => 'required | max:50',
                'description.*' => 'required | max:400',
                'email.*'       => 'required | max:100',
                'phone_no.*'    => 'required',
                'address.*'     => 'required | max:100',
                'map_url'       => 'required'
            ]
        ]
    ],
    'footer' => [
        'single' => [
            'field_name' => [
                'logo'     => 'file',
                'text'     => 'text',
                'email'    => 'text',
                'phone_no' => 'number',
                'address'  => 'text',
            ],
            'validation' => [
                'logo.*' => 'nullable | max:3072 | image | mimes:jpg,png,jpeg',
                'text.*' => 'nullable | max:250',
                'email.*' => 'required  | max:80',
                'phone_no.*' => 'required',
                'address.*' => 'required | max:150'
            ]
        ],
        'multiple' => [
            'field_name' => [
                'icon' => 'text',
                'url'  => 'text',
            ],
            'validation' => [
                'icon.*' => 'required',
                'url.*'  => 'required'
            ]
        ]
    ],
    'login'=>[
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|string|max:60',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'
            ]
        ]
    ],
    'plan' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'short_text' => 'textarea'
            ],
            'validation' => [
                'heading.*' => 'required|string|max:40',
                'sub_heading.*' => 'required|string|max:40',
                'short_text.*' => 'required|string|max:300'
            ]
        ]
    ],

    'message' => [
        'required' => 'This field is required.',
        'min'      => 'This field must be at least :min characters.',
        'max'      => 'This field may not be greater than :max characters.',
        'image'    => 'This field must be image.',
        'logo'     => 'This field must be logo.',
        'mimes'    => 'This image must be a file of type: jpg, jpeg, png.',
        'integer'  => 'This field must be an integer value',
    ],

    'content_media' => [
        'image'        => 'file',
        'logo'         => 'file',
        'my_link'      => 'url',
        'icon'         => 'icon',
        'count_number' => 'number',
        'start_date'   => 'date',
    ]
];

