<?php

namespace nnwebEmotionDices;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Doctrine\Common\Collections\ArrayCollection;

class nnwebEmotionDices extends Plugin {
	private $pluginname = 'nnwebEmotionDices';

	public static function getSubscribedEvents() {
		return [
			'Enlight_Controller_Action_PostDispatchSecure_Widgets_Emotion' => 'extendsEmotionTemplates',
			'Enlight_Controller_Action_PostDispatchSecure_Backend_Emotion' => 'onPostDispatchBackendEmotion',
			'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
			'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascriptFiles'
		];
	}

	public function activate(ActivateContext $context) {
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::activate($context);
	}

	public function deactivate(DeactivateContext $context) {
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::deactivate($context);
	}

	public function update(UpdateContext $context) {
		
		if (version_compare($context->getCurrentVersion(), "1.1.0", "<=")) {
			
			$emotionComponentInstaller = $this->container->get('shopware.emotion_component_installer');
			$element = $emotionComponentInstaller->createOrUpdate($this->getName(), "Würfel-Banner", [
				'name' => 'Würfel-Banner',
				'template' => 'component_nnweb_emotion_dices',
				'xtype' => 'emotion-components-nnweb-emotion-dices',
				'cls' => 'nnweb-emotion-dices'
			]);
			
			$element->createField([
				'name' => $this->pluginname . '_link_artikel',
				'fieldLabel' => 'Link auf Artikel',
				'xtype' => 'emotion-components-fields-article',
				'supportText' => 'Wird hier ein Artikel ausgewählt, wird der obige Link überschrieben.',
				'allowBlank' => true,
				'position' => '19'
			]);
			
		}
		
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::update($context);
	}

	public function install(InstallContext $context) {
		parent::install($context);
		$this->registerEmotionElement();
	}

	private function registerEmotionElement() {
		$emotionComponentInstaller = $this->container->get('shopware.emotion_component_installer');
		
		$element = $emotionComponentInstaller->createOrUpdate($this->getName(), $this->pluginname, [
			'name' => 'Würfel-Banner',
			'template' => 'component_nnweb_emotion_dices',
			'xtype' => 'emotion-components-nnweb-emotion-dices',
			'cls' => 'nnweb-emotion-dices'
		]);
		
		// Hintergrund
		$element->createDisplayField([
			'name' => 'hintergrund',
			'defaultValue' => 'Hintergrund',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createMediaField([
			'name' => $this->pluginname . '_hintergrundbild',
			'fieldLabel' => 'Hintergrundbild',
			'supportText' => 'Bitte wählen Sie ein Bild aus der Media-Verwaltung.',
			'allowBlank' => true,
			'translatable' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_hintergrundbild_parallax',
			'fieldLabel' => 'Würfel-Box mit Parallax-Effekt',
			'defaultValue' => '',
			'supportText' => 'Dieser Effekt wirkt, wenn viele Würfel-Boxen mit gleichem Hintergrundbild nebeneinander liegen.',
			'allowBlank' => true
		]);
		
		// Box
		$element->createDisplayField([
			'name' => 'textbox',
			'defaultValue' => 'Textbox',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Textausrichtung',
			'name' => $this->pluginname . '_textbox_text_align',
			'supportText' => 'Sie können hier den Textfluss festlegen.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionDices.store.TextAlignStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => 'center'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_textbox_hintergrundfarbe',
			'fieldLabel' => 'Textbox Hintergrundfarbe',
			'defaultValue' => '#000000',
			'supportText' => 'Geben Sie einen Hintergrund an. Zum Beispiel #000000 für schwarz.',
			'allowBlank' => true,
			'helpTitle' => 'Weitere Möglichkeiten',
			'helpText' => 'Probieren sie auch Werte aus wie "purple", "linear-gradient(#909,#606)", "rgba(0,0,0,0.8)".'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_textbox_schriftfarbe',
			'fieldLabel' => 'Textbox Schriftfarbe',
			'defaultValue' => '#FFFFFF',
			'supportText' => 'Geben Sie eine Schriftfarbe im Hex-Format an an. Zum Beispiel #FFFFFF für weiß.',
			'allowBlank' => true
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Textbox-Position auf Touch-Geräten',
			'name' => $this->pluginname . '_textbox_touch_position',
			'supportText' => 'Auf Touch-Geräten existiert kein Hover-Effekt, deshalb wird hier eine andere Darstellung gewählt.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionDices.store.TextboxPositionStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => 'left'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_textbox_cls',
			'fieldLabel' => 'Textbox CSS-Klasse',
			'defaultValue' => '',
			'supportText' => 'Mehrere Klassen können mit einem Leerzeichen getrennt hinzugefügt werden.',
			'allowBlank' => true
		]);
		
		// Überschrift
		$element->createDisplayField([
			'name' => 'ueberschrift',
			'defaultValue' => 'Überschrift',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_ueberschrift_anzeigen',
			'fieldLabel' => 'Überschrift anzeigen',
			'defaultValue' => false
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Überschrift-Tag',
			'name' => $this->pluginname . '_ueberschrift_tag',
			'supportText' => 'Sie können hier den HTML-Tag, der für die Überschrift genutzt wird, eingeben.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionDices.store.HeadlineTagStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => 'h2'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_ueberschrift_text',
			'fieldLabel' => 'Überschrift',
			'defaultValue' => '',
			'supportText' => 'Sie können hier eine Überschrift eingeben.',
			'allowBlank' => true,
			'translatable' => true
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_ueberschrift_cls',
			'fieldLabel' => 'Überschrift CSS-Klasse',
			'defaultValue' => '',
			'supportText' => 'Mehrere Klassen können mit einem Leerzeichen getrennt hinzugefügt werden.',
			'allowBlank' => true
		]);
		
		// Text
		$element->createDisplayField([
			'name' => 'text',
			'defaultValue' => 'Text',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_text_anzeigen',
			'fieldLabel' => 'Text anzeigen',
			'defaultValue' => false
		]);
		
		$element->createTextAreaField([
			'name' => $this->pluginname . '_text_text',
			'fieldLabel' => 'Text',
			'defaultValue' => '',
			'supportText' => 'Sie können hier einen Text eingeben',
			'allowBlank' => true,
			'translatable' => true
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_text_cls',
			'fieldLabel' => 'Text CSS-Klasse',
			'defaultValue' => '',
			'supportText' => 'Mehrere Klassen können mit einem Leerzeichen getrennt hinzugefügt werden.',
			'allowBlank' => true
		]);
		
		// Link
		$element->createDisplayField([
			'name' => 'link',
			'defaultValue' => 'Link',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_link',
			'fieldLabel' => 'Link',
			'defaultValue' => '',
			'supportText' => 'Sie können hier einen Link für das Element definieren.',
			'allowBlank' => true,
			'translatable' => true
		]);
			
		$element->createField([
			'name' => $this->pluginname . '_link_artikel',
			'fieldLabel' => 'Link auf Artikel',
			'xtype' => 'emotion-components-fields-article',
			'supportText' => 'Wird hier ein Artikel ausgewählt, wird der obige Link überschrieben.',
			'allowBlank' => true,
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Link öffnen in',
			'name' => $this->pluginname . '_link_target',
			'supportText' => 'Sie können hier festlegen, wo der Link geöffnet wird.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionDices.store.LinkTargetStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => '_self'
		]);
	}

	public function addLessFiles(\Enlight_Event_EventArgs $args) {
		$less = new \Shopware\Components\Theme\LessDefinition(array(), array(
				__DIR__ . '/Resources/views/frontend/_public/src/less/all.less'
		), __DIR__);
		
		return new ArrayCollection(array(
				$less
		));
	}

	public function onCollectJavascriptFiles(\Enlight_Event_EventArgs $args) {
		$jsFiles = array(
				__DIR__ . '/Resources/views/frontend/_public/src/js/nnweb_emotion_dices.js'
		);
		return new ArrayCollection($jsFiles);
	}

	public function extendsEmotionTemplates(\Enlight_Event_EventArgs $args) {
		$controller = $args->getSubject();
		$view = $controller->View();
		$view->addTemplateDir(__DIR__ . '/Resources/views/frontend/');
	}

	public function onPostDispatchBackendEmotion(\Enlight_Controller_ActionEventArgs $args) {
		$controller = $args->getSubject();
		$view = $controller->View();
		$view->addTemplateDir(__DIR__ . '/Resources/views/');
		$view->extendsTemplate('backend/emotion/nnweb_emotion_dices/view/detail/elements/nnweb_emotion_dices.js');
		$view->extendsTemplate('backend/emotion/nnweb_emotion_dices/nnweb_emotion_dices_store.js');
	}
}