<?php

namespace Jatdung\DcatVditor;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;


class Vditor extends Field
{
    protected $view = 'dcat-vditor::index';

    /**
     * 编辑器配置.
     *
     * @var array
     * @link
     */
    protected $options = [
        'height' => 500,
        'upload' => ['url' => '']
    ];

    protected $enable = true;

    protected $language;

    protected $disk;

    protected $imageUploadDirectory = 'markdown/images';


    /**
     * 设置编辑器容器高度.
     *
     * @param int $height
     * @return $this
     */
    public function height($height)
    {
        $this->options['height'] = $height;

        return $this;
    }

    public function readOnly(bool $value = true)
    {
        $this->enable = !$value;
        return $this;
    }

    /**
     * 设置文件上传存储配置.
     *
     * @param string $disk
     * @return $this
     */
    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * 设置图片上传文件夹.
     *
     * @param string $dir
     * @return $this
     */
    public function imageDirectory(string $dir)
    {
        $this->imageUploadDirectory = $dir;

        return $this;
    }

    /**
     * 自定义图片上传接口.
     *
     * @param string $url
     * @return $this
     */
    public function imageUrl(string $url)
    {
        return $this->mergeOptions(['upload' => ['url' => $this->formatUrl(admin_url($url))]]);
    }

    /**
     * @return string
     */
    protected function defaultImageUploadUrl()
    {
        return $this->formatUrl(route(admin_route_name('vditor.upload')));
    }

    /**
     * @param string $url
     * @return string
     */
    protected function formatUrl(string $url)
    {
        return Helper::urlWithQuery(
            $url,
            [
                '_token' => csrf_token(),
                'disk'   => $this->disk,
                'dir'    => $this->imageUploadDirectory,
            ]
        );
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->options['placeholder'] = $this->placeholder();
        $this->options['value'] = $this->value;
        $this->options['cdn'] = admin_asset('vendor/dcat-admin-extensions/jatdung/dcat-vditor');

        if (empty($this->options['upload']['url'])) {
            $this->options['upload']['url'] = $this->defaultImageUploadUrl();
        }

        $this->addVariables([
            'options' => JavaScript::format($this->options),
            'enable'  => $this->enable,
        ]);

        return parent::render();
    }
}
