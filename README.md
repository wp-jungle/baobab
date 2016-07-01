# Baobab

Baobab is born from the frustration of not finding a lean framework to develop our themes. The closest match we 
found - and we borrowed quite a bit from it - is [Themosis](https://github.com/themosis/framework) but it was very much 
made to develop full web applications based on WordPress.

We wanted something to help us build great WordPress themes that could be installed anywhere. And this is how Baobab 
started.

## Configuration over code

I believe that a theme should not contain any code that is not specific to it. As much work as possible should be done 
using configuration files. This is what Baobab provides for all components it uses: Kirki, TGM, etc.

## Clean theme architecture

Baobab not only provides lots of tools to help you build a good theme, but we also have a blank sample theme to get you 
started with that. Introducing [Balsa starter theme](https://github.com/marvinlabs/balsa).

## Not reinventing the wheel

Baobab was never meant to be yet another theme development framework including all you could need to build a theme. We
instead chose to build on the best libraries available in the open-source world and make them work together in a unified
way.

### Theme customizer
 
[Kirki](http://kirki.org) is an enhancement to the WordPress customizer. We decided to stay clear from
frameworks such as Redux in order to stick with the WordPress way of providing theme settings. Kirki is very much in 
the spirit of Baobab in that it provides just the code missing to make the WordPress customizer a better tool.

### Template engine

[Blade](http://laravel.com/docs/4.2/templates) is a template language which aims at making rendering HTML enjoyable. We
did not want to have files containing all those ugly `<?php echo get_the_date() ?>` statements. Instead we found that 
writing `{{ get_the_date() }}` was much nicer.

So we have decided to allow you to use all this goodness, borrowed some ideas from [Themosis](http://framework.themosis.com/docs/views/) 
and [Mickael Mattson](https://github.com/MikaelMattsson/blade), throw in my own improvements and there we have a Blade
engine ready to be used in our themes.

### Dependencies

I always find it a pity when premium themes provide their own plugins for such things as integrating Google Analytics,
providing a portfolio post type, a contact form, etc. These features clearly belong to plugins: what happens when you 
switch themes? All your analytics settings - and worse - all your portfolio items are lost too because the post type 
is no longer declared.
 
So we need a good way to declare that our theme requires or recommends the use of this and that plugin. Well, 
[TGM Plugin Activation](https://github.com/TGMPA/TGM-Plugin-Activation) is a well known library that does this thing for quite some time now. And they do it well. So
we integrated it to Baobab and take care of all the boiler-plate code for you. Just specify your dependencies in the 
corresponding configuration file.





