<?php

return [
    'mode'                     => 'utf-8',
    'format'                   => 'A5',
    'default_font_size'        => '12',
    'default_font'             => 'examplefont',
    'margin_left'              => 10,
    'margin_right'             => 10,
    'margin_top'               => 10,
    'margin_bottom'            => 10,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => '',
    'watermark'                => '',
    'show_watermark'           => false,
    'show_watermark_image'     => false,
    'watermark_font'           => 'examplefont',
    'display_mode'             => 'fullpage',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'auto_language_detection'  => false,
    'temp_dir'                 => storage_path('app'),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,
    'custom_font_dir'  => public_path('fonts'), // don't forget the trailing slash!
    'custom_font_data' => [
        'examplefont' => [ 
            'R'  => 'DanaFaNum-Regular.ttf',   
            'B'  => 'DanaFaNum-Bold.ttf',       
            'I'  => 'DanaFaNum-Black.ttf',     
            'BI' => 'DanaFaNum-Thin.ttf', 
            'useOTL' => 0xFF,
        ]

    ]
];
