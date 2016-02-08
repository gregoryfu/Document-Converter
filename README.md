# Rhino Workflow

A front end workflow for web developers that utilizes the Gulp task runner, SMACSS (Scalable and Modular Architecture for CSS), BEM (Block, Element, Modifier) naming conventions, and modular PHP using includes.

## Getting Started
This guide is designed to help Windows users get everything set up. After the initial installation of these few utilities you will be able to start new projects with ease.

* Install [Node.js](http://nodejs.org).
* Install [Ruby](http://rubyinstaller.org/downloads).
* Install [SASS](http://sass-lang.com/install) by opening up your command line and typing `gem install sass`. After it loads you can make sure it installed correctly by typing `sass -v`. It should return SASS with the version number.
* Install GULP globally by opening your command line and typing `npm install --global gulp`.
* Download the latest version of [Rhino Workflow](http://rhinoworkflow.com).
* Extract all the downloaded files into your project folder.
* Double click on the `load_modules.bat` file. This will load GULP locally and all the NPM packages that GULP uses to process the SASS and minify files.
* From now on all you have to do to start a new project is copy the original Rhino Workflow files into another folder and double click the `load_modules.bat` file, then open up your command line and `cd` into your project folder and type `gulp`. It will now listen to any changes made in the `source` folders, compile the SASS, and minify your files. To tell gulp to stop watching just type `Ctrl c` in the command line, then `y` to stop.

## Using Rhino Workflow
To get the most out of Rhino Workflow, you should invest time into learning SASS and the SMACSS and BEM methodologies. Also learning basic PHP and using includes will help you greatly in maintaining a web application.

* Everything that gets deployed to the actual server environment is in the `app` folder. This includes the source unminified SASS and JavaScript files as a source mapping feature will be added in the future for easier debugging.
* In the `app` folder you have an `assets` folder and all your individual web pages. These individual web pages are set up to use PHP includes for common blocks of code used across all pages, such as the head of the document, header and footer. These re-usable blocks of code are stored in `assets/php`.
* In your `assets` folder you have a`css` folder holding the minified CSS file, an `img` folder for all images and icons, and a `js` folder for the minified JavaScript. These minified and concatenated files are meant to reduce the amount of HTTP requests your applicaton makes which greatly improves performance.
* You then have a `source_js` and `source_scss` folders. All the code you write in each respective folder will be concatenated together and minified automatically into the respective `js`, and `css` folders.
* The `source_js` folder is concatenated together in a logical order defined by the `gulpfile.js`. Starting with all the code in the `vendor` folder, followed by the `plugins` folder, and lastly the `scripts.js` file which contains all the users custom code. This ensures all your written code is only called after all the dependencies have loaded into the DOM. The individual files within the `vendor` and `plugin` folders will be concatenated in an alphabetical order.
* The `source_scss` folder is also concatenated together in a logical order defined by the `styles.scss` file. This is used as a main index that calls all the SASS partials in a specified order. Since we are using a highly modular architecture, our main index `styles.scss` is importing other indexes of the subfolders that organize our structure.
* The subfolders within our `source_scss` folder are as follows: `base`, `layout`, `modules`, `states`, and `utilities`. If you look in our main index `styles.scss` you can see that everything is imported in a certain order starting with the most basic down to more specific styles.
* `utilities` is where we have our SASS variables, mixins, and functions. Since these are only used to help us write code and not style our page, they need to be imported first into our main index `styles.scss`.
* `base` contains the most basic styles. This includes CSS resets, grid systems, frameworks, and a base style sheet which only uses element selectors.
* `layout` is where we start to see the BEM naming convention. Anything that could be considered a major block that helps to layout the web page will be styled here. Only the appropriate classes that were assigned to these parent elements should be styled here.
* `modules` includes anything that could be considered an element or modifier of a block element. These styles should be for classes used on elements that have no knowledge of their parents, and should be able to be re-used anywhere on the site.
* `states` is for any state specific styles, such as media query breakpoints, collapsed navigation, or print styles.