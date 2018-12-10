<?php
Route::namespace('Auth')->group(function(){
    Route::post('login',[
        'uses'=>'AuthController@postLogin',
        'as'=>'auth.login'
    ]);
    Route::get('logout',[
        'uses'=>'AuthController@logout',
        'as'=>'auth.logout'
    ]);
});
Route::namespace('Docbao')->group(function(){
    Route::get('/',[
        'uses'=>'IndexController@home',
        'as'=>"docbao.login"
    ]);
    Route::get('dm_cha',[
        'uses'=>'IndexController@dm_cha',
        'as'=>'docbao.dm_cha'
    ]);
    Route::get('dm_con',[
        'uses'=>'IndexController@dm_con',
        'as'=>'docbao.dm_com'
    ]);
    Route::get('/{id}',[
        'uses'=>'IndexController@index',
        'as'=>'docbao.index'
    ]);
    Route::get('cat/{id}/{page}',[
        'uses'=>'IndexController@cat',
        'as'=>'docbao.cat'
    ]);
    Route::get('detail/{id}',[
        'uses'=>'IndexController@detail',
        'as'=>'docbao.detail'
    ]);
});
Route::namespace('Admin')->prefix('admin')->middleware('auth')->group(function(){
    Route::prefix('index')->group(function(){
        Route::get('',[
            'uses'=>'IndexController@index',
            'as'=>'admin.index.index'
        ]);
    });
    Route::prefix('danhmuc')->group(function(){
        Route::get('index',[
            'uses'=>'DanhmucController@index',
            'as'=>'admin.danhmuc.index'
        ]);
        Route::get('add',[
            'uses'=>'DanhmucController@add',
            'as'=>'admin.danhmuc.add'
        ]);
        Route::get('edit',[
            'uses'=>'DanhmucController@edit',
            'as'=>'admin.danhmuc.edit'
        ]);
        Route::post('edit',[
            'uses'=>'DanhmucController@postEdit',
            'as'=>'admin.danhmuc.edit'
        ]);
        Route::get('del/{id}',[
            'uses'=>'DanhmucController@del',
            'as'=>'admin.danhmuc.del'
        ])->middleware("role:admin");
    });
    Route::prefix('tintuc')->group(function(){
        Route::get('index',[
            'uses'=>'TintucController@index',
            'as'=>'admin.tintuc.index'
        ]);
        Route::get('add',[
            'uses'=>'TintucController@add',
            'as'=>'admin.tintuc.add'
        ]);
        Route::post('add',[
            'uses'=>'TintucController@postAdd',
            'as'=>'admin.tintuc.add'
        ]);
        Route::get('edit/{tintuc_id}',[
            'uses'=>'TintucController@edit',
            'as'=>'admin.tintuc.edit'
        ]);
        Route::post('edit',[
            'uses'=>'TintucController@postEdit',
            'as'=>'admin.tintuc.postedit'
        ]);
        Route::get('del/{id}',[
            'uses'=>'TintucController@del',
            'as'=>'admin.tintuc.del'
        ])->middleware("role:admin");
        Route::post('active',[
            'uses'=>'TintucController@active',
            'as'=>'admin.tintuc.active'
        ]);
        //rss
        Route::get('rss/{id}',[
            'uses'=>'TintucController@rss',
            'as'=>'admin.tintuc.rss'
        ]);
        Route::post('addrss',[
            'uses'=>'TintucController@addrss',
            'as'=>'admin.tintuc.rss.add'
        ]);
        Route::get('update/{id}',[
            'uses'=>'TintucController@update',
            'as'=>'admin.tintuc.rss.update'
        ]);
        Route::get('rss/del/{id}',[
            'uses'=>'TintucController@rssdel',
            'as'=>'admin.tintuc.rss.del'
        ])->middleware("role:admin");

        Route::post('move_tintuc',[
            'uses'=>'TintucController@move_tintuc',
            'as'=>'admin.tintuc.rss.move_tintuc'
        ]);
        Route::get('tintuc_rss/del/{id}',[
            'uses'=>'TintucController@tintucrssdel',
            'as'=>'admin.tintuc.rss.tintucdel'
        ]);
        Route::get('xemthu',[
            'uses'=>'TintucController@xemthu',
            'as'=>'admin.tintuc.rss.xemthu'
        ]);
    });
    Route::prefix('users')->group(function(){
        Route::get('index',[
            'uses'=>'UsersController@index',
            'as'=>'admin.users.index'
        ]);
        Route::get('add',[
            'uses'=>'UsersController@add',
            'as'=>'admin.users.add'
        ]);
        Route::post('add',[
            'uses'=>'UsersController@postAdd',
            'as'=>'admin.users.add'
        ]);
        Route::get('edit/{id}',[
            'uses'=>'UsersController@edit',
            'as'=>'admin.users.edit'
        ]);
        Route::post('edit/{id}',[
            'uses'=>'UsersController@postEdit',
            'as'=>'admin.users.edit'
        ]);
        Route::get('del/{id}',[
            'uses'=>'UsersController@del',
            'as'=>'admin.users.del'
        ])->middleware("role:admin");
        Route::get('active',[
            'uses'=>'UsersController@active',
            'as'=>'admin.users.active'
        ]);
        Route::get('doimk',[
            'uses'=>'UsersController@doimk',
            'as'=>'admin.users.doimk'
        ]);
    });
});