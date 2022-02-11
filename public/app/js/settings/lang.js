angular
	.module('Neaop')
	.config(function($translateProvider){
		var lang = navigator.language;
		var langBase = lang.substr(0, 2);
		var langCountry = lang.substr(3);

		console.log('Language: '+langBase+'; Country: '+langCountry)
		switch (langBase) {
			case 'en':
				defaultLang = 'en';
				break;
			case 'pt':
				defaultLang = 'pt-br';
				break;
			default:
				defaultLang = 'es';
		}

		$translateProvider.preferredLanguage(defaultLang);

		$translateProvider.useStaticFilesLoader({
  			prefix: '/app/lang/',
  			suffix: '.json'
		});

	});