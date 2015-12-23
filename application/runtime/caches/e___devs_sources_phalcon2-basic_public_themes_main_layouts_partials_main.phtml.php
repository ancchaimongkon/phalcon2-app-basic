<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php echo !empty($pageTitle) ? $pageTitle . " | " : "" ?> <?php echo CBaseSystem::$pageTitle; ?></title>
        <link rel="shortcut icon" href="/public/images/favicon-32x32.ico" type="image/x-icon">
        <link rel="icon" href="/public/images/favicon-32x32.ico" type="image/x-icon">
        <?php echo $this->assets->outputCss('cssHeader'); ?>
        <?php echo $this->assets->outputJs('jsHeader'); ?> 
         
    </head>
    <body>
         
        

<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="row">
                <?php echo $this->getContent(); ?>
            </div>
        </div>
    </div>
</div>


         
        <?php echo $this->assets->outputCss('cssFooter'); ?> 
        <?php echo $this->assets->outputJs('jsFooter'); ?>
          
           
    </body>
</html>