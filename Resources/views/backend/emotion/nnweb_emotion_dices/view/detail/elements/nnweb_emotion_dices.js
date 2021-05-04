//
//{block name="backend/emotion/view/detail/elements/base"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Emotion.view.detail.elements.nnwebEmotionDices', {

    extend: 'Shopware.apps.Emotion.view.detail.elements.Base',

    alias: 'widget.detail-element-emotion-components-nnweb-emotion-dices',

    componentCls: 'emotion--nnweb-emotion-dices',

    icon: ' data:image/png;base64,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',

    createPreview: function() {
        var me = this,
            preview = '',
            image = me.getConfigValue('nnwebEmotionDices_hintergrundbild'),
            position = 'center center',
            style;

        console.log(image);
        if (Ext.isDefined(image)) {
            style = Ext.String.format('background-image: url([0]); background-position: [1];', image, position);

            preview = Ext.String.format('<div class="x-emotion-banner-element-preview" style="[0]"></div>', style);
        }

        return preview;
    }
});
//{/block}