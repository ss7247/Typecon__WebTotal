<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Web Total
 * 
 * @package WebTotal
 * @author astar
 * @version 1.0.0
 * @link http://typecho.org
 */
class WebTotal_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array('WebTotal_Plugin', 'webtotal');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
        $name = new Typecho_Widget_Helper_Form_Element_Text('total', NULL, '1', _t('设置访问数量'));
        $form->addInput($name);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function webtotal()
    {
        $config = Typecho_Widget::widget('Widget_Options')->plugin('WebTotal');
        $num = $config->total ? $config->total : '未设置' ;
        if(is_numeric($num)) {
            $db = Typecho_Db::get();
            $num++;
            $total = array('total'=>$num);
            $db->query($db->update('table.options')->rows(array('value' => serialize($total)))->where('name = ?', 'plugin:WebTotal'));
            echo '<div style="text-align: center;">您是第<span style="color:red;"> '.$num.' </span> 位访客</div>';
        }
        else
            echo $num;
    }
}
