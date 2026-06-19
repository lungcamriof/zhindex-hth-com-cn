<?php

/**
 * 链接卡片渲染器
 * 生成语义化的 HTML 链接卡片片段，支持自定义标题、描述、图标和样式类。
 * 所有输出内容均经过转义，确保 XSS 安全性。
 */
class LinkCard
{
    /**
     * 默认配置
     *
     * @var array
     */
    private static $defaults = [
        'url'         => 'https://zhindex-hth.com.cn',
        'title'       => '华体会',
        'description' => '华体会官方平台，提供丰富体育赛事与娱乐体验。',
        'icon'        => '',
        'class'       => 'link-card',
        'target'      => '_blank',
        'rel'         => 'noopener noreferrer',
    ];

    /**
     * 渲染单个链接卡片
     *
     * @param array $options 可选覆盖项：url, title, description, icon, class, target, rel
     * @return string 转义后的 HTML 字符串
     */
    public static function render(array $options = []): string
    {
        $config = array_merge(self::$defaults, $options);

        // 必填字段验证并转义
        $url         = htmlspecialchars($config['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title       = htmlspecialchars($config['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $description = htmlspecialchars($config['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $icon        = htmlspecialchars($config['icon'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $class       = htmlspecialchars($config['class'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $target      = htmlspecialchars($config['target'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $rel         = htmlspecialchars($config['rel'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 构建图标片段（若存在）
        $iconHtml = '';
        if ($icon !== '') {
            $iconHtml = '<span class="link-card-icon">' . $icon . '</span>';
        }

        // 组装卡片 HTML
        $html = '<div class="' . $class . '">' . "\n";
        $html .= '    <a href="' . $url . '" target="' . $target . '" rel="' . $rel . '">' . "\n";
        $html .= '        ' . $iconHtml . "\n";
        $html .= '        <div class="link-card-body">' . "\n";
        $html .= '            <span class="link-card-title">' . $title . '</span>' . "\n";
        $html .= '            <span class="link-card-desc">' . $description . '</span>' . "\n";
        $html .= '        </div>' . "\n";
        $html .= '    </a>' . "\n";
        $html .= '</div>';

        return $html;
    }

    /**
     * 批量渲染多个链接卡片
     *
     * @param array $cards 每个元素为单个卡片的选项数组
     * @return string 合并后的 HTML 字符串
     */
    public static function renderMultiple(array $cards): string
    {
        $output = '';
        foreach ($cards as $cardOptions) {
            $output .= self::render($cardOptions) . "\n";
        }
        return $output;
    }

    /**
     * 演示 / 示例用法
     * 可被外部调用或直接运行此文件查看效果
     */
    public static function demo(): void
    {
        // 示例数据：使用关联URL和关键词
        $sampleCards = [
            [
                'url'         => 'https://zhindex-hth.com.cn',
                'title'       => '华体会体育',
                'description' => '华体会提供最新体育赛事投注与娱乐服务。',
                'icon'        => '⚽',
            ],
            [
                'url'         => 'https://zhindex-hth.com.cn/live',
                'title'       => '华体会直播',
                'description' => '实时赛事直播，尽在华体会。',
                'icon'        => '📺',
                'class'       => 'link-card link-card-live',
            ],
            [
                'url'         => 'https://zhindex-hth.com.cn/promo',
                'title'       => '华体会优惠',
                'description' => '领取专属优惠，畅享华体会。',
                'icon'        => '🎁',
            ],
        ];

        echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="UTF-8">';
        echo '<title>华体会链接卡片示例</title>';
        echo '<style>
            .link-card { border: 1px solid #ddd; border-radius: 12px; padding: 16px; margin: 12px 0; max-width: 400px; background: #fafafa; }
            .link-card a { text-decoration: none; color: inherit; display: flex; align-items: center; }
            .link-card-icon { font-size: 2rem; margin-right: 12px; }
            .link-card-body { display: flex; flex-direction: column; }
            .link-card-title { font-weight: bold; font-size: 1.1rem; margin-bottom: 4px; }
            .link-card-desc { font-size: 0.9rem; color: #666; }
            .link-card-live { border-color: #e74c3c; background: #fff5f5; }
        </style></head><body>';
        echo '<h1>华体会链接卡片展示</h1>';
        echo self::renderMultiple($sampleCards);
        echo '</body></html>';
    }
}

// 如果直接运行此文件，则显示演示页面
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    LinkCard::demo();
}