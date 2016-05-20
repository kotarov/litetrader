<h1>Initializing of data</h1>
<p>HTML pages are cached, so the data that must be filled to withdraw with ajax request.</p>

<hr>

<h2>Exmaples</h2>

<h3>html</h3>
<pre class="prettyprint"><code class="lang-html">
<select data-get="filte.to.json"></select>
...
<input data-get="file.to.vlue">
...
<textarea data-get="file.to.value"></textarea>
</code></pre>

<h3>json</h3>
<pre class="prettyprint"><code class="lang-javascript">
{ 
    data : {   
        id : 2, 
        text:"The text goes here"
    }
}
</code></pre>