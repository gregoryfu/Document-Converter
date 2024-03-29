<!DOCTYPE html>

<?php
  $title = "Article Converter";
  $description = "This program is meant to take articles written in Microsoft Word and convert them into a clean HTML equivalent that makes posting and editing a breeze. Support will start off with converting \"web page, filtered\" files saved through Microsoft Word into clean paragraph tag seperated sections.";
  include "assets/php/head.php";

    // Document Handler
    if(isset($_POST["submit"])){
        $newDocument = $_POST["document"];
        if(isset($_POST["readable"])){
            $readable = true;
        } else {$readable = false;}
        if(isset($_POST["endnotes"])){
            $endnotes = true;
        } else {$endnotes = false;}
        
        
        // Add sup tags to mso class spans
        $newDocument = preg_replace('/(\<span[\s]*class\=msoendnotereference\>)/is', '<sup>', $newDocument);
        
        // Change ending sup tag to an actual </sup> tag
        $newDocument = preg_replace('/(?<=\<sup\>).*?\K(\<\/span\>)/is', '</sup>', $newDocument);
        
        // Change i tags with a space into just a space
        $newDocument = preg_replace('/(\<i\>\s{1}\<\/i\>)/is', ' ', $newDocument);
        $newDocument = preg_replace('/(\<i\>\s{1}\n\<\/i\>)/is', ' ', $newDocument);
        
        // Change b tags with a space into just a space
        $newDocument = preg_replace('/(\<b\>\s{1}\<\/b\>)/is', ' ', $newDocument);
        $newDocument = preg_replace('/(\<b\>\s{1}\n\<\/b\>)/is', ' ', $newDocument);
        
        // Remove main garbage (ie. head, style, and script tags)
        $pattern = [
            // MAJOR
            // Remove EVERYTHING between head tags
            '/(\<head.*?head\>)/is',
            // Remove EVERYTHING between style tags
            '/(\<style.*?style\>)/is',
            // Remove EVERYTHING between script tags
            '/(\<script.*?script\>)/is',
            // Remove EVERYTHING within the first body tag
            '/(\<body.*?\>)/is',
            // Remove end body tag
            '/(\<\/body\>)/is',
            // Remove start html tag
            '/(\<html.*?\>)/is',
            // Remove end html tag
            '/(\<\/html\>)/is',
            // Remove EVERYTHING between del tags
            '/(\<del.*?\<\/del\>)/is',
            // Remove EVERYTHING within first div tag
            '/(\<div.*?\>)/is',
            // Remove end div tag
            '/(\<\/div\>)/is',
            // Remove EVERYTHING within the first span tag
            '/(\<span.*?\>)/is',
            // Remove end span tag
            '/(\<\/span\>)/is',
            //Remove extra sup tag at end of sup
            '/(?<=\<\/sup\>)\s*(\<\/sup\>)/is',
            
            // Remove EVERYTHING within style attributes
            '/(style\=\'.*?\')/is',
            // Remove EVERYTHING within class attributes
            '/(class\=.*?[^\s|\>]*)/is',
            // Remove All tags that have [AW1] in it
            '/(<[^\/>][^>]*>\[AW1\]<\/[^>]+>[\w\s]*)/is',
            // Remove non breaking spaces
            '/(\&nbsp\;)/is',
            // Remove whitespace before end p tags
            '/(\s)*(?=\<\/p\>)/is',
            // Remove space after superscript numbers
            '/(?<=\<sup\>\d)(\s)*(?=\<\/sup\>)/is',
            // Remove white spaces within the opening p tag
            '/(\<p\K\s+)/is',
            // Remove EVERYTHING within first ins tag
            '/(\<ins.*?>)/is',
            // Remove ending ins tag
            '/(\<\/ins\>)/is',
            // Match ALL empty HTML tags
            '/(<[^\/>][^>]*><\/[^>]+>)/i'
        ];
        $newDocument = preg_replace($pattern, '', $newDocument);
        
        
        
        

        // Replace M-Dashes with &mdash;
        $newDocument = preg_replace('/(\—)/i', "&mdash;", $newDocument);
        // Replace N-Dashes with &ndash;
        $newDocument = preg_replace('/(\–)/i', "&ndash;", $newDocument);
        // Replace light middot with &bull;
        $newDocument = preg_replace('/(\·)/i', "&bull;", $newDocument);
        
        
        
        
        
        
        
        
        
        if($endnotes == true){
            // Replace Endnotes with H4
            $newDocument = preg_replace('/(\<p\>[\s\<b\>]*endnotes[\s\<\/b\>]*<\/p\>)/is', "<h4 style=\"margin-bottom: 15px; font-weight: bold;\">Endnotes</h4>", $newDocument);
            // Replace p tags after "endnotes" with li tags
            $liPattern = [
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<p\>\d\.*\s*)/is'
            ];
            $newDocument = preg_replace($liPattern, "<li>", $newDocument);
            // Replace closing p tags after "endnotes" with closing li tags
            $closeLiPattern = [
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is',
                '/(?<=endnotes\<\/h4\>).*?\K(\<\/p\>)/is'
            ];
            $newDocument = preg_replace($closeLiPattern, "</li>", $newDocument);
            // Place opening ol tag
            $newDocument = preg_replace('/(?<=endnotes\<\/h4\>).*?\K(\<li\>)/is', "<ol><li>", $newDocument);
            // Place closing ol tag
            $newDocument = preg_replace('/(?<=endnotes\<\/h4\>).*\K(\<\/li\>)/is', "</li></ol>", $newDocument);
        }
        
        
        
        
        
        
        
        // Add blockquotes to paragraphs which only contain the word "blockquote"
        // Adjust for users who apparently can't spell "quote"
        $newDocument = preg_replace('/(\<p.*\>\s*block.*?te\s*\<\/p\>)/i', "<blockquote>", $newDocument);
        // Add closing blockquote tag to paragraphs which only contain the word "endblockquote"
        $newDocument = preg_replace('/(\<p.*\>\s*endblock.*?te\s*\<\/p\>)/i', "</blockquote>", $newDocument);
        
        
        // Replace align with style tag
        $newDocument = preg_replace('/(align=center)/i', " style=\"text-align: center;\"", $newDocument);
        $newDocument = preg_replace('/(align=left)/i', " style=\"text-align: left;\"", $newDocument);
        $newDocument = preg_replace('/(align=right)/i', " style=\"text-align: right;\"", $newDocument);
        
        
        // Remove whitespace before closing p tags
        $newDocument = preg_replace('/(\s+)(?=\<\/p\>)/is', '', $newDocument);
        // Extra round of removing empty HTML tags
        $newDocument = preg_replace('/(<[^\/>][^>]*><\/[^>]+>)/i', '', $newDocument);
        // Extra round of removing empty HTML tags
        $newDocument = preg_replace('/(<[^\/>][^>]*><\/[^>]+>)/i', '', $newDocument);
        
        
        // Process metadata
        // Postdate
        preg_match('/m-postdate\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $postDate = $matches[0];
        // Subject
        preg_match('/m-title\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $title = $matches[0];
        // Author
        preg_match('/m-author\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $author = $matches[0];
        // Categories
        preg_match('/m-categories\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $categories = $matches[0];
        // WP Categories
        preg_match('/m-wpcategories\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $wpcategories = $matches[0];
        // Tags
        preg_match('/m-tags\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $tags = $matches[0];
        // Teaser
        preg_match('/m-teaser\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $teaser = $matches[0];
        // Guest Author Bio
        preg_match('/m-bio\s*:*(?:\<b\>)*(?:\<u\>)*(?:\<i\>)*\K(.*?)(?=\<\/)/is', $newDocument, $matches);
        $bio = $matches[0];
        
        
        // Remove metadata after it's been saved in variables
        $pattern = [
            // Postdate
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-postdate[\s\S]*?<\/p\>)/is',
            // Subject
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-title[\s\S]*?<\/p\>)/is',
            // Author
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-author[\s\S]*?<\/p\>)/is',
            // Categories
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-categories[\s\S]*?<\/p\>)/is',
            // WP Categories
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-wpcategories[\s\S]*?<\/p\>)/is',
            // Tags
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-tags[\s\S]*?<\/p\>)/is',
            // Teaser
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-teaser[\s\S]*?<\/p\>)/is',
            // Author Bio
            '/(\<p[\s\S]*\>[\s\<b\>\<i\>]*m-bio[\s\S]*?<\/p\>)/is'
        ];
        $newDocument = preg_replace($pattern, '', $newDocument);

        
        // Prepare New Document to display on web
        $newDocument = htmlspecialchars($newDocument);
        
        // Adjusting to make Readable Document
        $readableDocument = $newDocument;
        $readableDocument = preg_replace('/\&lt\;\/p\&gt\;/is', "&lt;/p&gt;<br><br>", $readableDocument);
        $readableDocument = preg_replace('/\&lt\;blockquote\&gt\;/is', "&lt;blockquote&gt;<br><br>", $readableDocument);
        $readableDocument = preg_replace('/\&lt\;\/blockquote\&gt\;/is', "&lt;/blockquote&gt;<br><br>", $readableDocument);
        $readableDocument = preg_replace('/\&lt\;\/h4\&gt\;/is', "&lt;/h4&gt;<br><br>", $readableDocument);
        $readableDocument = preg_replace('/\&lt\;ol\&gt\;/is', "&lt;ol&gt;<br>", $readableDocument);
        $readableDocument = preg_replace('/\&lt\;\/li\&gt\;/is', "&lt;/li&gt;<br>", $readableDocument);
        

    }
?>

<?php include "assets/php/header.php"; ?>

<!-- Page Content Goes Here -->

<div class="inputArea container">
    <form action="" method="post">
        <textarea name="document" placeholder="Paste the word document here..."></textarea>
        <label><input type="checkbox" name="readable" value="true" checked>Format readable</label>
        <label><input type="checkbox" name="endnotes" value="true" checked>Endnotes to p > ol</label>
        <input name="submit" type="submit" value="submit">
    </form>
</div>

<div class="results container">
    <div class="inner-container">
        <h2>Edit the result below if needed and then copy by clicking "Copy".</h2>
        <p>post date: <?php if(isset($postDate)){ echo $postDate;} ?></p>
        <p>title: <?php if(isset($title)){ echo $title;} ?></p>
        <p>author: <?php if(isset($author)){ echo $author;} ?></p>
        <p>categories: <?php if(isset($categories)){ echo $categories;} ?></p>
        <p>wordpress categories: <?php if(isset($wpcategories)){ echo $wpcategories;} ?></p>
        <p>tags: <?php if(isset($tags)){ echo $tags;} ?></p>
        <p>teaser: <?php if(isset($teaser)){ echo $teaser;} ?></p>
        <p>Guest Author Bio: <?php if(isset($bio)){ echo $bio;} ?></p>
        <div class="outerDiv" contenteditable="true">
            <?php
            if(isset($newDocument) && $readable != true){ echo $newDocument;}
            if(isset($readableDocument) && $readable == true){ echo $readableDocument;}
            ?>
        </div>
    </div>
</div>


<?php include "assets/php/footer.php"; ?>