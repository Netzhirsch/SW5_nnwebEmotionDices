{block name="widgets_emotion_components_nnweb_emotion_dices"}
	{if $Data.nnwebEmotionDices_link_produkt_id}
		{$link = {url controller="detail" sArticle=$Data.nnwebEmotionDices_link_produkt_id}}
	{else}
		{$link = $Data.nnwebEmotionDices_link}
	{/if}
	
	<a
		href="{$link}"
		target="{$Data.nnwebEmotionDices_link_target}"
		class="
			nnweb_emotion_dices
			{$Data.nnwebEmotionDices_hintergrund_position}
			{if $Data.nnwebEmotionDices_hintergrundbild_parallax}parallax{/if}
			touch-{$Data.nnwebEmotionDices_textbox_touch_position}
		"
		style="background-image:url('{$Data.nnwebEmotionDices_hintergrundbild}') ">
		
		<div class="wrapper" style="text-align:{$Data.nnwebEmotionDices_textbox_text_align};background:{$Data.nnwebEmotionDices_textbox_hintergrundfarbe};">
			{if $Data.nnwebEmotionDices_ueberschrift_anzeigen}
				<{$Data.nnwebEmotionDices_ueberschrift_tag} class="headline {$Data.nnwebEmotionDices_ueberschrift_cls}" style="color:{$Data.nnwebEmotionDices_textbox_schriftfarbe};">
					{$Data.nnwebEmotionDices_ueberschrift_text}
				</{$Data.nnwebEmotionDices_ueberschrift_tag}>
			{/if}
			{if $Data.nnwebEmotionDices_text_anzeigen}
				<p class="{$Data.nnwebEmotionDices_text_cls}" style="color:{$Data.nnwebEmotionDices_textbox_schriftfarbe};">{$Data.nnwebEmotionDices_text_text}</p>
			{/if}
			{if $Data.nnwebEmotionDices_button_anzeigen}
				<a class="{$Data.nnwebEmotionDices_button_cls}" href="{$link}" target="{$Data.nnwebEmotionDices_button_link_target}">
					<span>{$Data.nnwebEmotionDices_button_text}</span>
				</a>
			{/if}
		</div>
	</a>
{/block}