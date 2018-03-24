<?php

/**
 *  @author  Preme W. <preme_won@truecorp.co.th>
 *  @since   Jan 27, 2014
 *  @version   1.0
 *
 */
class BannerRepository implements BannerRepositoryInterface
{
    
    protected $pcmsClient;
    
    public function __construct() {
        $this->pcmsClient = App::make('pcms');
    }
    
    public function getByPosition($position = NULL) {
        if (is_array($position)) {
            $positions = implode("|", $position);
        } else {
            $positions = $position;
        }
        
        // Get all collections via PCMS API
        $params = array('position' => $positions);
        
        $response = $this->pcmsClient->apiv2("banners", $params, 'GET');
        //echo '<pre>';
        //print_r($response);
        //echo '</pre>';
        
        $out = array();
        if (!empty($response['code'])) {
            $out = array();
            if ($response['code'] == 200) {
                
                foreach ($response['data'] as $key => $value) {
                    $out['position_' . $value['id']]['id'] = $value['id'];
                    $out['position_' . $value['id']]['name'] = $value['name'];
                    $out['position_' . $value['id']]['description'] = $value['description'];
                    $out['position_' . $value['id']]['max_group_active'] = $value['max_group_active'];
                    $out['position_' . $value['id']]['status_flg'] = $value['status_flg'];
                    $out['position_' . $value['id']]['group_total'] = $value['group_total'];
                    
                    if (!empty($value['group_list'])) {
                        foreach ($value['group_list'] as $g_key => $g_value) {
                            $out['position_' . $value['id']]['group_list'][$g_key]['id'] = $g_value['id'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['pkey'] = $g_value['pkey'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['name'] = $g_value['name'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['description'] = $g_value['description'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['is_random'] = $g_value['is_random'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['status_flg'] = $g_value['status_flg'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['show_per_time'] = $g_value['show_per_time'];
                            $out['position_' . $value['id']]['group_list'][$g_key]['banner_total'] = $g_value['banner_total'];
                            
                            if (!empty($g_value['banner_list'])) {
                                
                                $banner_list = array();
                                foreach ($g_value['banner_list'] as $b_key => $b_value) {
                                    $banner_list[$b_key] = array('id' => $b_value['id'], 'banner_group_id' => $b_value['banner_group_id'], 'pkey' => $b_value['pkey'], 'name' => $b_value['name'], 'type' => $b_value['type'], 'target' => $b_value['target'], 'width' => $b_value['width'], 'height' => $b_value['height'], 'img_path' => $b_value['img_path'], 'url_link' => $b_value['url_link'], 'status_flg' => $b_value['status_flg'], 'youtube_embed' => $b_value['youtube_embed'], 'description' => $b_value['description'], 'effectived_at' => $b_value['effectived_at'], 'expired_at' => $b_value['expired_at']);
                                    
                                    if (!empty($b_value['map_area'])) {
                                        $map_area_list = array();
                                        foreach ($b_value['map_area'] as $m_key => $m_value) {
                                            $map_area_list[] = array('id' => $m_value['id'], 'pkey' => $m_value['pkey'], 'product_id' => $m_value['product_id'], 'map_position' => $m_value['map_position'], 'url_link' => $m_value['url_link'], 'tag_alt' => $m_value['tag_alt'], 'created_at' => $m_value['created_at']);
                                        }
                                        
                                        $banner_list[$b_key]['map_area'] = $map_area_list;
                                        if ($g_value['is_random'] == "Y") {
                                            
                                            //--- Random banners in same group ---//
                                            //-- This function is contained in /app/container/helpers/array.php ---//
                                            //-- passed by reference (Variable's address will changed in function)
                                            shuffle_assoc($banner_list);
                                        }
                                    } else {
                                        
                                        //--- Do not have map area of this banner ---//
                                        $banner_list[$b_key]['map_area'] = array();
                                    }
                                }
                                
                                $out['position_' . $value['id']]['group_list'][$g_key]['banner_list'] = $banner_list;
                            } else {
                                $out['position_' . $value['id']]['group_list'][$g_key]['banner_list'] = array();
                            }
                        }
                    } else {
                        $out['position_' . $value['id']]['group_list'] = array();
                    }
                }
            }
        }
        return $out;
    }
    
    public function getBanner($position = array()) {
        if (is_array($position)) {
            $positions = implode("|", $position);
        } else {
            $positions = $position;
        }
        
        // Get all collections via PCMS API
        $params = array('position' => $positions);
        $response = $this->pcmsClient->apiv2("banners", $params, 'GET');
        
        if (!empty($response['code']) && $response['code'] == 200) {
            
            return $response['data'];
        }
        return null;
    }
};
