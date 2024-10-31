=== PluGeSHin ===
Contributors: pajtai
Donate link: http://netlumination.com/
Tags: syntax highlighting, GeSHi
Requires at least: 2.5
Tested up to: 3.2.1
Stable tag: 2.5

PluGeSHin is a Wordpress plugin by Peter Ajtai that lets you use the syntax highlighting of GeSHi through Wordpress shortcodes.

== Description ==

[PluGeSHin](http://netlumination.com/blog/plugeshin) is a [Wordpress](http://wordpress.org/) plugin by Peter Ajtai that lets you use 
the syntax highlighting of [GeSHi](http://qbnz.com/highlighter/) through Wordpress [shortcodes](http://codex.wordpress.org/Shortcode_API).

The format for using PluGeSHin is:

    [geshi] CODE TO BE HIGHLIGHTED [/geshi]

= Features =

* Use shortcodes in WP-Admin to mark text for syntax higlighting on the front end
* Use optional attributes in the short codes to control:
    * Language used for highlighting
    * Whether to show line numbers
    * Start line number to use
    * Line marked with an attention grabbing color
    * Target of links to documentation
* TinyMCE split button:
    * You can wrap your code with the touch of a button in simple `[geshi]` shortcode without any attributes
    * You can use the PluGeSHin helper to select shortcode attributes and wrap the code with the created shortcode
* WP-Admin settings page that lets you
    * Set the default language
    * Set whether to show line numbers by default
    * Set the default target for links to documentation    
    * Draft a sample test page with the push of a button

= Quick Start =

1. Paste code into Visual editor in WP-Admin
1. Select code with mouse
1. Hit the `G` PluGeSHin button
    1. You can also hit the dropdown arrow next to the button
    1. Use the helper to choose your attributes

---

To see working examples of GeSHi with PluGeSHin visit [this page](http://netlumination.com/blog/plugeshin).

PluGeSHin comes with a helpful WP-Admin Settings Page. You can draft a sample Post from that page with the push of a button.
The sample page has multiple examples of PluGeSHin shortcodes, so you can both make sure the plugin is working, and so you 
can look at how the examples were written.

A list of supported languages is shown on the PluGeSHin Settings Page in a dropdown.

= PluGeSHin Attributes =

PluGeSHin can take one or more attributes, like this:

    [geshi attribute="ATTRIBUTE VALUE"] CODE TO BE HIGHLIGHTED [/geshi]

All attributes are optional. Leaving them out will trigger default attributes. The default values for the highlighted language and whether line 
numbers are shown can be set on the PluGeSHin Settings Page in WP-Admin.

The attributes you can use with PluGeSHin are:

* `lang` - is the language used for highlighting. The codes available can be looked up on PluGeSHin's Settings Page from the dropdown.
* `nums` - controls whether line numbers are shonw. nums="1" shows line number nums="0" does not.
* `start` - controls what the first line number is. You should always have line numbers showing if you set start.
* `highlight` - let's you pick the line numbers to draw attention to. It is a comma separated list. The numbers are lines relative to the first one.
* `target` - pick the target for anchor element links to documentation

Note that the highlighted code will be wrapped in `<pre>` tags and the class attribute of the `<pre>` tags will be `PluGeSHin` and the name of the 
highlighted language. This way you can easily use CSS to tweak the styling of your code blocks. You should also wrap the unhighlighted code 
in `<pre>` tags. The short tags themselves should not be within `<pre>` tags.

Here is an example using all four possible attributes
    
    [geshi lang="cpp" start="37" nums="1" highlight="4,13"] 
        CODE TO BE HIGHLIGHTED
    [/geshi]

Finally, remember to use `Shift+Enter` if you're typing code and not pasting it in. You don't have to - PluGeSHin will still work if you don't - 
but it'll look nicer for you in the Visual edit screen.

= Detailed use instructions =

Above, in the "Quick Start" section you can read about how to use PluGeSHin with the TinyMCE button. Below are more detailed 
instructions, in case you want to do things by hand or need to trouble shoot malformed HTML.

The following instructions are for using the Visual editor mode. You can also use the HTML editor mode with PluGeSHin. The important 
thing to remember is that PluGeSHin can only be responsible for what's between the short codes, so don't wrap the entire short code 
block in a PRE on the outside!

Steps for using PluGeSHin manually:

1. Pick Paragraph format from the dropdown.
1. Hit `Alt-Shift-Z` if you don't see the Format drop down in the TinyMCE toolbar
1. Type `[geshi]`
1. Hit enter twice
1. Type `[/geshi]`
1. Hit the up arrow once
1. Pick the `Preformatted` format.
1. Type or paste in your code. The `Preformat` will preserve your indentation.
1. Save your post and View or Preview it from the front end. The code will now be highlighted.

The code you type or paste in should be preformatted - in `<pre>` tags. The `[geshi]` short code tags should not be preformatted.

= Stay tuned for =

Support of more GeSHi methods. Next ones will probably be the option to show code in a `<div>` or a `<pre>` as well as the ability
to set header and footer information.

= Contact =

If you have questions, problems, or general ramblings, correspond with me at `spam` dot `database` at `gmail` dot `com`. 

== Installation ==

* Download PluGeSHin
* Unzip the file
* Upload the "plugeshin" directory and contents to the wp-content/plugins directory on your server.
* In the WP-Admin panel navigate to the Plugins page.
* Click the `Activate` option for PluGeSHin.

After you have PluGeSHin installed, you can:

1. Use the PluGeSHin shortcodes and PluGeSHin button as outlined above
1. Set global PluGeSHin defaults on the WP-Admin PluGeSHin Settings page.
1. Draft a sample Post with the push of a button to make sure PluGeSHin is working and to look at examples of its use.

== Frequently Asked Questions ==

= Where is the PluGeSHin button? =

It is in the TinyMCE toolbar on the right. It has a blue "G" (for GeSHi) on a white background. If you click the G,
you'll wrap your selection with a PluGeSHin short code of no attributes. You can click on the little arrow to the right
of the G to open the modal to create a PluGeSHin short code with attributes. You don't have to use the button. You can
just type the short codes in by hand if you want, but you have to make sure that the formatting is correct.

= How do I know what language codes to use? =

If you click the little arrow to the right of the G in the PluGeSHin TinyMCE button, you can pick to create a short code
with attributes. If you select this, the modal will have a drop down of language names and codes. You can also
go to the PluGeSHin Settings Page in WP-Admin. In either case, you have to use the language code. For example if you want 
to use the language Java(TM) 2 Platform Standard Edition 5.0, you can see that the language code to use is `java5`. So you would write:
`[geshi lang="java5"] CODE TO BE HIGHLIGHTED [/geshi]`

= What happens if there's a GeSHi error? =

That code block gets the class attribute of "geshi-error", and the error is written to a log file in the PluGeSHin folder.

= Why are there a bunch of funny characters instead of quote marks in the highlighted code? =

The code is not wrapped in PRE tags. When you look at the HTML view of your post it should look like this:

    [geshi]
    <pre>
      // some code here
        alert("example");
    </pre>
    [/geshi]

= Everything's highlighted, but I can see two scroll bars or my code is wrapped in two PRE tags =

PluGeSHin only know about things between the two shortcode tags, so you cannot wrap the shortcodes in PRE tags. Take a
look at the previous answer for correct formatting.

= I'm typing code between the PluGeSHin shortcode tags, and everything highlights as it should, but there are annoyingly large spaces between my lines of code in the WP-Admin window. What is going on? =

Hit `Shift + Enter` between lines instead of `Enter`. Hitting simple `Enter` will wrap each line in a `<pre>` tag. PluGeSHin isn't bothered
by this, and it doesn't affect the front end, but it does cause big gaps between lines in the editor.

= I hit the PluGeSHin button, and my entire text was replaced with `[geshi] [/geshi]`. What happened? =

You had the entire window selected. This is the default if you haven't actively made a selection yet. Furtonately,
the PluGeSHin button supports undo, so just click in the edit window and hit `CTR + Z` or the `undo` button.

= How do I add more language files to GeSHi within PluGeSHin? =

Drop your language file in the PluGeSHin directory at `GeSHi-1.0.8.10/geshi/geshi/`. After you add the file you have to deactivate
and then reactivate PluGeSHin, since the languages array is built at activation. There will soon be an option to add languages, so 
that you don't have to do this. 

Make sure you backup all the changes you make, since updating PluGeSHin will overwrite any changes you've made!

= How can I make my documentation links open in new tabs? =

Go to the PluGeSHin settings page and pick `_blank` as your default target. You can also set this to as the target element on individual
PluGeSHin shortcodes.

== Screenshots ==

1. A typical view of the WP-Admin screen when using PuGeSHin. You can use either the View or HTML modes, but I find using the View mode easier.
2. The highlighting shown on the front end due to the shortcode tags used in Screenshot-1.
3. The PluGeSHin TinyMCE split button at work
4. The PluGeSHin modal
5. The grammar for the PluGeSHin shortcode. Thanks to the [Railroad Diagram Generator](http://railroad.my28msec.com/rr/ui) for the diagram!

== Changelog ==

= 1.0 =
* First stable release of PluGeSHin

= 1.1 =
* Minor updates to readme.txt

= 1.2 =
* Added PluGeSHin TinyMCE button

= 2.0 =
* Added TinyMCE split button

= 2.1 =
* Added railroad diagram help

= 2.2 =
* Minor bug fixes

= 2.3 =
* PluGeSHin errors to error log

= 2.4 =
* Fixed curly quotes appearing as HTML entity codes when code not wrapped in PRE tags

= 2.5 =
* Target attribute added

== Upgrade Notice ==

= 1.1 =
Minor changes to readme.txt

= 1.2 =
This adds a PluGeSHin TinyMCE button to the Visual Editor.

= 2.0 =
This upgrades the TinyMCE button to a split button that makes a wrap without attributes or one with attributes.
The PluGeSHin modal helps you pick the attributes.

= 2.1 =
Adds railroad diagram help to settings menu.

= 2.2 =
Fixes minor RR Diagram error and removes a print_r that can occasionally be encountered.

= 2.3 =
PluGeSHin errors to error log

= 2.4 =
Bug fix: Curly quotes will no longer appear as HTML entity codes if your codes is not wrapped in PRE tags.

= 2.5 =
Added "target" attribute.
Plese back up your GeSHi-1.0.8.10 directory if you've made any changes to it (e.g. language files / styles).
