<?php

return CMap::mergeArray(
             require(dirname(__FILE__) . '/main.php'), array(
            'id' => 'front',
            'name' => 'NhacVN-Admin',
            'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "admin",
            'viewPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "admin",
            'defaultController' => 'adminUser/profile',
            'theme' => 'admin-new',
            // autoloading model and component classes
            'import' => array(
                'application.models.admin.*',
                'application.components.admin.*',
                'application.modules.srbac.controllers.SBaseController',
                'application.vendors.utilities.*',                
                'application.modules.radio.models.*',
            ),
            // application components
            'components' => array(
                // authManager
                'authManager' => array(
                    // The type of Manager (Database)
                    'class' => 'application.modules.srbac.components.SDbAuthManager',
                    // The default role
                    'defaultRoles' => array('guest'),
                    // The database component used
                    'connectionID' => 'db',
                    // The itemTable name (default:authitem)
                    'itemTable' => 'admin_access_items',
                    // The assignmentTable name (default:authassignment)
                    'assignmentTable' => 'admin_access_assignments',
                    // The itemChildTable name (default:authitemchild)
                    'itemChildTable' => 'admin_access_itemchildren',
                ),
                'user' => array(
                    // enable cookie-based authentication
                    'allowAutoLogin' => true,
                    //'loginUrl' => array('/admin/login'),
                	'authTimeout'=>10800*3, // 3 tiếng
                	//'class' => 'WebUser',

                ),
            		
            	'image'=>array(
            		'class'=>'ext.image.CImageComponent',
            		// GD or ImageMagick
            		'driver'=>'GD',
            		// ImageMagick setup path
            		'params'=>array('directory'=>'/opt/local/bin'),
            	),
                'errorHandler' => array(
                    'errorAction' => '/admin/error/',
                ),
            ),
            // modules
            'modules' => array(
                'seo',
            	'reports',
            	'radio',
                // customize automatic code generation
                'gii' => array(
                    'class' => 'system.gii.GiiModule',
                    'password' => '1',
                    'ipFilters' => array('127.0.0.1', '127.0.2.2', '10.0.0.83','*'),
                    // 'newFileMode'=>0666,
                    // 'newDirMode'=>0777,

                    'generatorPaths' => array(
                        'application.gii', // a path alias
                    ),
                ),
                // module srbac
                'srbac' => array(
                    'userclass' => 'AdminAdminUserModel', //optional defaults to User
                    'userid' => 'id', //optional defaults to userid
                    'username' => 'username', //optional defaults to username
                    'debug' => false, //optional defaults to false
                    'pageSize' => 10, //optional defaults to 15
                    'superUser' => 'SuperAdmin', //optional defaults to Authorizer
                    'css' => 'srbac.css', //optional defaults to srbac.css
                    'layout' => 'application.views.admin.layouts.newstyle', //optional defaults to
                    // application.views.layouts.main, must be an existing alias
                    'notAuthorizedView' => 'srbac.views.authitem.unauthorized', // optional defaults to
                    //srbac.views.authitem.unauthorized, must be an existing alias
                    'alwaysAllowed' => array(//optional defaults to gui
                    ),
                    'userActions' => array(//optional defaults to empty array
                        'Show', 'View', 'List'
                    ),
                    'listBoxNumberOfLines' => 15, //optional defaults to 10
                    //'imagesPath' => 'srbac.images', //optional defaults to srbac.images
                    'imagesPack' => 'tango', //optional defaults to noia
                    'iconText' => true, //optional defaults to false
                    //'header'=>'srbac.views.authitem.header', //optional defaults to srbac.views.authitem.header, must be an existing alias
                    // 'footer'=>'srbac.views.authitem.footer', //optional defaults to srbac.views.authitem.footer, must be an existing alias
                    // 'showHeader'=>true, //optional defaults to false
                    // 'showFooter'=>true, //optional defaults to false
                    'alwaysAllowedPath' => 'srbac.components', //optional defaults to srbac.components
                ),
            ),
            'params' => array(
            	'defaultLanguage' => 'vi_vn',
                'pageSize' => 30,
            	// Login config
            	'login'=>array(
            			'limit_block'=>5, // So lan login fail bi block
            			'time_block'=> 10, // Thoi gian block (phut)
            	),
            ),
    )
);
?>
