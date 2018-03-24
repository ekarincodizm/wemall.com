<?php

class ContactusController extends FrontBaseController {

    public function __construct()
    {
        parent::__construct();

        $this->theme->breadcrumb()->add(__('contact_us'), URL::toLang('contact_us'));
    }
	
    public function getIndex()
    {
		$this->theme->setTitle( __('footer_contact_us_title') );
		
		$this->theme->asset()->container('footer')->script('google-maps-js', 'http://maps.googleapis.com/maps/api/js?v=3&sensor=false');
		$this->theme->asset()->container('footer')->script('google-library-js', 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js', array('google-maps-js'));
		$this->theme->asset()->container('footer')->usePath()->add('contact-us-js', 'js/create-map.js', array('google-maps-js', 'google-library-js'));

        return $this->theme->scope('contact.contact_us')->render();

    }

}