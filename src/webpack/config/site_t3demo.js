const relExtPath = "../../extensions/site_t3demo";
const relScssPath = `${relExtPath}/Resources/Private/Scss`;
const relCssPath = `${relExtPath}/Resources/Public/Css`;

module.exports = {
	scss: {
		path: {
			source: relScssPath,
			target: relCssPath
		},
		// target (CSS) : source (SCSS)
		files: {
			[`${relCssPath}/main.css`]: `${relScssPath}/main.scss`,
			[`${relCssPath}/faqlist.css`]: `${relScssPath}/faqlist.scss`,
			[`${relCssPath}/login.css`]: `${relScssPath}/login.scss`,
			[`${relCssPath}/form.css`]: `${relScssPath}/form.scss`,
			[`${relCssPath}/../Backend/Css/be_rte.css`]: `${relScssPath}/be_rte.scss`,
			[`${relCssPath}/../Backend/Css/Skin/t3skin_override.css`]: `${relScssPath}/t3skin_override.scss`
		},
		// Group same CSS media query rules into one
		groupMediaQueries: true
	},
	js: {
		path: {
			source: `${relExtPath}/Resources/Private/JavaScript`,
			target: `${relExtPath}/Resources/Public/JavaScript`,
			public: "/typo3conf/ext/site_t3demo/Resources/Public/JavaScript/"
		},
		filename: {
			main: "main",
			commonVendor: "common-vendor"
		}
	}
};
