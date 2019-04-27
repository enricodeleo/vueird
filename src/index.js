import Vue from 'vue';
import VueLogger from 'vuejs-logger';
import VueLazyload from 'vue-lazyload';
import BootstrapVue from 'bootstrap-vue';
import VueMq from 'vue-mq';

// Bootstrap elements
import 'bootstrap';

// Local utilities
import dashify from './util/dashify';

// Pages
import single from './pages/single';
import undefinedPage from './pages/undefinedPage';

// Styles
import './style.scss';

// Config
const DEV = process.env.NODE_ENV === 'development';
const VueLoggerOptions = {
  isEnabled: true,
  logLevel: DEV ? 'debug' : 'error',
  stringifyArguments: false,
  showLogLevel: true,
  showMethodName: true,
  separator: '|',
  showConsoleColors: true
};
const components = {
  single,
};

// Do not show tips out of development mode
Vue.config.productionTip = DEV;

// Vue plugins
Vue.use(BootstrapVue);
Vue.use(VueLogger, VueLoggerOptions);
Vue.use(VueLazyload, {
  preLoad: 1.3,
  attempt: 1
});
Vue.use(VueMq, {
  breakpoints: { // default breakpoints - customize this
    xs: -Infinity,
    sm: 540,
    md: 720,
    lg: 992,
    xl: Infinity,
  },
  defaultBreakpoint: 'xs'
});

/**
 * Fallback to undefined page
 * @description When no expected body class is found, mount a generic component to .fallback-undefined-component
 */
function fallBackToUndefinedPage() {
  const fallbackClass = 'fallback-undefined-component';
  const componentCandidates = document.getElementsByClassName(fallbackClass);
  let vm;

  if (componentCandidates.length) {
    const componentElement = componentCandidates[0];

    // Try to create vue component
    try {
      vm = new Vue(undefinedPage).$mount(componentElement);
    } catch (error) {
      throw new Error(error);
    }
  }

  // Component found
  if (vm) {
    return vm;
  }

  return;
}

/**
 * Initialize Fake Router
 * @description Cycle possible html elements in order to mount a vue component accordingly
 *
 * @param {array} componentsKeys
 * @param {number} index
 */
function initializeFakeRouter(componentsKeys, index) {
  const componentName = componentsKeys[index];
  const componentCandidates = document.getElementsByClassName(dashify(componentName));
  let vm;

  // Skip if all components were cycled
  if (componentName && componentCandidates.length) {
    const componentElement = componentCandidates[0];

    // Try to create vue component
    try {
      vm = new Vue(components[componentName]).$mount(componentElement);
    } catch (error) {
      throw new Error(error);
    }

    // Component found
    if (vm) {
      return vm;
    }
  }

  // Whether to continue cycling or fallback
  if (index + 1 === componentsKeys.length ) {
    return fallBackToUndefinedPage();
  } else {
    // Continue iteration
    return initializeFakeRouter(componentsKeys, index + 1);
  }
};

/** Load Events */
jQuery(document).ready(() => initializeFakeRouter(Object.keys(components), 0));
