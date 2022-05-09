# EasyMDE

[EasyMDE](https://github.com/Ionaru/easy-markdown-editor) field type for Markdown content in Craft CMS 3+.

## Installation

Add the package to your composer.json file

For Craft CMS 3, use version 3

```
"acoustep/craft-easymde": "~3.0.0"
```

For Craft CMS 4, there is currently a beta branch

```
"acoustep/craft-easymde": "dev-Craft4"
```

Install the plugin

```
./craft install/plugin craft-easymde
```

## Usage

Go to your Settings, Fields, select or create a field and choose EasyMDE field type.

Then if you're using Twig in your frontend you can parse it with the `markdown` helper or use the [Wordsmith](https://wordsmith.docs.topshelfcraft.com/guide/installation.html) plugin

```twig
{{entry.content|markdown}}
```

## Todo

* Custom configuration
* Choose EasyMDE version
* Add other EasyMDE functionality
