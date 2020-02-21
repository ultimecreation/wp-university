<!DOCTYPE html>
<html <?php language_attributes('fr'); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="navbar">
        <div class="container">
            <h1 class="brand"><strong>Acme</strong><span>Université</span></h1>

            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="responsive-menu">

            <?php wp_nav_menu(array('theme_location' => 'primary_menu')); ?>
        </div>
    </div>