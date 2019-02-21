/*
 *	Defines the Plugin Class
 */
var Plugin = function(){ };
/*
 *	Defines the CyrToLat Class
 */
var CyrToLat = function(config){
	this.preset = config ? config.preset : "ru";

	this.firstLetterAssociations = {
		"а": "a",
		"б": "b",
		"в": "v",
		"ґ": "g",
		"г": "g",
		"д": "d",
		"е": "e",
		"ё": "e",
		"є": "ye",
		"ж": "zh",
		"з": "z",
		"и": "i",
		"і": "i",
		"ї": "yi",
		"й": "i",
		"к": "k",
		"л": "l",
		"м": "m",
		"н": "n",
		"о": "o",
		"п": "p",
		"р": "r",
		"с": "s",
		"т": "t",
		"у": "u",
		"ф": "f",
		"х": "h",
		"ц": "c",
		"ч": "ch",
		"ш": "sh",
		"щ": "sh'",
		"ъ": "",
		"ы": "i",
		"ь": "",
		"э": "e",
		"ю": "yu",
		"я": "ya",
	}

	if (this.preset === "uk") {
		Object.assign(this.firstLetterAssociations, {
			"г": "h",
			"и": "y",
			"й": "y",
			"х": "kh",
			"ц": "ts",
			"щ": "shch",
			"'": "",
			"’": "",
			"ʼ": "",
		});
	}

	this.associations = Object.assign({}, this.firstLetterAssociations);

	if (this.preset === "uk") {
		Object.assign(this.associations, {
			"є": "ie",
			"ї": "i",
			"й": "i",
			"ю": "iu",
			"я": "ia",
		});
	}
};

CyrToLat.prototype.transform = function(input, spaceReplacement){
	if (!input) {
		return "";
	}

	let newStr = "";
	for (let i = 0; i < input.length; i++) {
		const isUpperCaseOrWhatever = input[i] === input[i].toUpperCase();
		let strLowerCase = input[i].toLowerCase();
		if (strLowerCase === " " && spaceReplacement) {
			newStr += spaceReplacement;
			continue;
		}
		let newLetter = this.preset === "uk" && strLowerCase === "г" && i > 0 && input[i - 1].toLowerCase() === "з"
			? "gh"
			: (i === 0 ? this.firstLetterAssociations : this.associations)[strLowerCase];
		if ("undefined" === typeof newLetter) {
			newStr += isUpperCaseOrWhatever ? strLowerCase.toUpperCase() : strLowerCase;
		}
		else {
			newStr += isUpperCaseOrWhatever ? newLetter.toUpperCase() : newLetter;
		}
	}

	return newStr;
};

CyrToLat.prototype.transformBack = function(input, spaceReplacement){
	if (!input) {
		return "";
	}

	let newStr = "";
	for (let i = 0; i < input.length; i++) {
		const isUpperCaseOrWhatever = input[i] === input[i].toUpperCase();
		let strLowerCase = input[i].toLowerCase();
		if (strLowerCase === " " && spaceReplacement) {
			newStr += spaceReplacement;
			continue;
		}
		let newLetter = this.preset === "uk" && strLowerCase === "г" && i > 0 && input[i - 1].toLowerCase() === "з"
			? "gh"
			: (i === 0 ? this.firstLetterAssociations : this.associations)[strLowerCase];
		if ("undefined" === typeof newLetter) {
			newStr += isUpperCaseOrWhatever ? strLowerCase.toUpperCase() : strLowerCase;
		}
		else {
			newStr += isUpperCaseOrWhatever ? newLetter.toUpperCase() : newLetter;
		}
	}

	return newStr;
};

/*
 *	Installs the plugin in the vuejs.
 */
Plugin.install = function(Vue, options){
	var op = options || {};

	var default_lang = op.preset || 'ru';

	Object.defineProperty(Vue.prototype, '$curToLat', {
		get:function () { return this.$root._cyrToLat }
	});

	if(typeof op != 'object'){
		console.error('[vue-cyrToLat] the options should be an object type.');
		return false;
	}

	Vue.mixin({
		beforeCreate:function() {
			Vue.util.defineReactive(this, '_cyrToLat',  new CyrToLat({preset:default_lang}));
		}
	});
};

module.exports = Plugin;
