
![Vueird Logo](./vueird.jpg)

_Thanks to everyone having starred my repo! To star it click on the image below, then it will be on top right. Thanks!_

[![Stargazers repo roster for @enricodeleo/vueird](https://reporoster.com/stars/enricodeleo/vueird)](https://github.com/enricodeleo/vueird/stargazers)

# Vueird

A WordPress starter theme that embraces today's practices: npm, webpack, livereload, declarative manipulation (Vue :heart:).

## Requirements

* Node.js
* Npm

## Installation

1. Clone this repository into your theme folder.
2. Open it in a shell and run `npm install`.
3. Activate the theme.

## Features

* Write modern Javascript. Babel does the rest
* Live reload
* SCSS
* Declarative DOM manipulation/events thanks to Vue
* Delightful developer experience through my _fake js router_ that attaches the right component to the right page.

## Develop

In order to take advantage of livereload, you need to target your wordpress development url in `./scripts/webpack.config.js` line 149 (e.g. localhost:8080, testsite.dev etc).

`npm start`

## Build for production

`npm run build`

## Refresh editor style

This theme generates a custom editor style used by the WordPress editor/Gutenberg that you can write in SCSS (`./src/editor-style.scss`).

`npm run editorstyle`

_________________________________________

## Author
[Enrico Deleo](https://enricodeleo.com)

# Are you looking for a modern, robust, portable WordPress development environment?
[Look no further, try my Wpacked WordPress development starter kit](https://github.com/enricodeleo/wpacked/)


