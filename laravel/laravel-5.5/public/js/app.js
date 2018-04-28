/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//
// require('./bootstrap');
//
// window.Vue = require('vue');
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });


var a = 30;
console.log("this is my variable ", a);

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: Error: Missing binding /var/www/html/laravel/laravel-5.5/node_modules/node-sass/vendor/linux-x64-59/binding.node\nNode Sass could not find a binding for your current environment: Linux 64-bit with Node.js 9.x\n\nFound bindings for the following environments:\n  - Linux 64-bit with Node.js 4.x\n\nThis usually happens because your environment has changed since running `npm install`.\nRun `npm rebuild node-sass --force` to build the binding for your current environment.\n    at module.exports (/var/www/html/laravel/laravel-5.5/node_modules/node-sass/lib/binding.js:15:13)\n    at Object.<anonymous> (/var/www/html/laravel/laravel-5.5/node_modules/node-sass/lib/index.js:14:35)\n    at Module._compile (internal/modules/cjs/loader.js:654:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:665:10)\n    at Module.load (internal/modules/cjs/loader.js:566:32)\n    at tryModuleLoad (internal/modules/cjs/loader.js:506:12)\n    at Function.Module._load (internal/modules/cjs/loader.js:498:3)\n    at Module.require (internal/modules/cjs/loader.js:598:17)\n    at require (internal/modules/cjs/helpers.js:11:18)\n    at Object.<anonymous> (/var/www/html/laravel/laravel-5.5/node_modules/sass-loader/lib/loader.js:3:14)\n    at Module._compile (internal/modules/cjs/loader.js:654:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:665:10)\n    at Module.load (internal/modules/cjs/loader.js:566:32)\n    at tryModuleLoad (internal/modules/cjs/loader.js:506:12)\n    at Function.Module._load (internal/modules/cjs/loader.js:498:3)\n    at Module.require (internal/modules/cjs/loader.js:598:17)\n    at require (internal/modules/cjs/helpers.js:11:18)\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:13:17)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at runLoaders (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModule.js:195:19)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:364:11\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:170:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:27:11)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:165:10)\n    at /var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:173:18\n    at loadLoader (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/loadLoader.js:36:3)\n    at iteratePitchingLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:169:2)\n    at runLoaders (/var/www/html/laravel/laravel-5.5/node_modules/loader-runner/lib/LoaderRunner.js:362:2)\n    at NormalModule.doBuild (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModule.js:182:3)\n    at NormalModule.build (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModule.js:275:15)\n    at Compilation.buildModule (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/Compilation.js:151:10)\n    at moduleFactory.create (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/Compilation.js:456:10)\n    at factory (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModuleFactory.js:241:5)\n    at applyPluginsAsyncWaterfall (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModuleFactory.js:94:13)\n    at /var/www/html/laravel/laravel-5.5/node_modules/tapable/lib/Tapable.js:268:11\n    at NormalModuleFactory.params.normalModuleFactory.plugin (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/CompatibilityPlugin.js:52:5)\n    at NormalModuleFactory.applyPluginsAsyncWaterfall (/var/www/html/laravel/laravel-5.5/node_modules/tapable/lib/Tapable.js:272:13)\n    at resolver (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModuleFactory.js:69:10)\n    at process.nextTick (/var/www/html/laravel/laravel-5.5/node_modules/webpack/lib/NormalModuleFactory.js:194:7)\n    at process._tickCallback (internal/process/next_tick.js:176:11)");

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/app.js");
module.exports = __webpack_require__("./resources/assets/sass/app.scss");


/***/ })

/******/ });