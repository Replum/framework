<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

/**
 * Factory for HTML objects
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class HtmlFactory
{
    /**
     * Create an A element
     */
    final public static function a(string $href = null) : Html\A
    {
        $obj = new Html\A();
        if ($href !== null) {
            $obj->setHref($href);
        }
        return $obj;
    }

    /**
     * Create an Abbr element
     */
    final public static function abbr() : Html\Abbr
    {
        return new Html\Abbr();
    }

    /**
     * Create an Address element
     */
    final public static function address() : Html\Address
    {
        return new Html\Address();
    }

    /**
     * Create an Article element
     */
    final public static function article() : Html\Article
    {
        return new Html\Article();
    }

    /**
     * Create an Aside element
     */
    final public static function aside() : Html\Aside
    {
        return new Html\Aside();
    }

    /**
     * Create an B element
     */
    final public static function b(string $text = null) : Html\B
    {
        $obj = new Html\B();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Bdi element
     */
    final public static function bdi() : Html\Bdi
    {
        return new Html\Bdi();
    }

    /**
     * Create an Bdo element
     */
    final public static function bdo() : Html\Bdo
    {
        return new Html\Bdo();
    }

    /**
     * Create an Blockquote element
     */
    final public static function blockquote() : Html\Blockquote
    {
        return new Html\Blockquote();
    }

    /**
     * Create an Body element
     */
    final public static function body() : Html\Body
    {
        return new Html\Body();
    }

    /**
     * Create an Br element
     */
    final public static function br() : Html\Br
    {
        return new Html\Br();
    }

    /**
     * Create an Button element
     */
    final public static function button() : Html\Button
    {
        return new Html\Button();
    }

    /**
     * Create an Input[type=button] element
     */
    final public static function buttonInput() : Html\ButtonInput
    {
        return new Html\ButtonInput();
    }

    /**
     * Create an Input[type=checkbox] element
     */
    final public static function checkboxInput() : Html\CheckboxInput
    {
        return new Html\CheckboxInput();
    }

    /**
     * Create an Cite element
     */
    final public static function cite(string $text = null) : Html\Cite
    {
        $obj = new Html\Cite();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Code element
     */
    final public static function code(string $text = null) : Html\Code
    {
        $obj = new Html\Code();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=color] element
     */
    final public static function colorInput() : Html\ColorInput
    {
        return new Html\ColorInput();
    }

    /**
     * Create an Data element
     */
    final public static function data(string $text = null) : Html\Data
    {
        $obj = new Html\Data();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=date] element
     */
    final public static function dateInput() : Html\DateInput
    {
        return new Html\DateInput();
    }

    /**
     * Create an Dd element
     */
    final public static function dd() : Html\Dd
    {
        return new Html\Dd();
    }

    /**
     * Create an Del element
     */
    final public static function del() : Html\Del
    {
        return new Html\Del();
    }

    /**
     * Create an Dfn element
     */
    final public static function dfn() : Html\Dfn
    {
        return new Html\Dfn();
    }

    /**
     * Create an Div element
     */
    final public static function div() : Html\Div
    {
        return new Html\Div();
    }

    /**
     * Create an Dl element
     */
    final public static function dl() : Html\Dl
    {
        return new Html\Dl();
    }

    /**
     * Create an Dt element
     */
    final public static function dt() : Html\Dt
    {
        return new Html\Dt();
    }

    /**
     * Create an Em element
     */
    final public static function em(string $text = null) : Html\Em
    {
        $obj = new Html\Em();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=email] element
     */
    final public static function emailInput() : Html\EmailInput
    {
        return new Html\EmailInput();
    }

    /**
     * Create an FigCaption element
     */
    final public static function figCaption() : Html\FigCaption
    {
        return new Html\FigCaption();
    }

    /**
     * Create an Figure element
     */
    final public static function figure() : Html\Figure
    {
        return new Html\Figure();
    }

    /**
     * Create an Input[type=file] element
     */
    final public static function fileInput() : Html\FileInput
    {
        return new Html\FileInput();
    }

    /**
     * Create an Footer element
     */
    final public static function footer() : Html\Footer
    {
        return new Html\Footer();
    }

    /**
     * Create an Form element
     */
    final public static function form() : Html\Form
    {
        return new Html\Form();
    }

    /**
     * Create an H1 element
     */
    final public static function h1(string $text = null) : Html\H1
    {
        $obj = new Html\H1();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an H2 element
     */
    final public static function h2(string $text = null) : Html\H2
    {
        $obj = new Html\H2();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an H3 element
     */
    final public static function h3(string $text = null) : Html\H3
    {
        $obj = new Html\H3();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an H4 element
     */
    final public static function h4(string $text = null) : Html\H4
    {
        $obj = new Html\H4();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an H5 element
     */
    final public static function h5(string $text = null) : Html\H5
    {
        $obj = new Html\H5();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an H6 element
     */
    final public static function h6(string $text = null) : Html\H6
    {
        $obj = new Html\H6();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Header element
     */
    final public static function header() : Html\Header
    {
        return new Html\Header();
    }

    /**
     * Create an Input[type=hidden] element
     */
    final public static function hiddenInput() : Html\HiddenInput
    {
        return new Html\HiddenInput();
    }

    /**
     * Create an Hr element
     */
    final public static function hr() : Html\Hr
    {
        return new Html\Hr();
    }

    /**
     * Create an I element
     */
    final public static function i(string $text = null) : Html\I
    {
        $obj = new Html\I();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Iframe element
     */
    final public static function iframe() : Html\Iframe
    {
        return new Html\Iframe();
    }

    /**
     * Create an Img element
     */
    final public static function img(string $src = null) : Html\Img
    {
        $obj = new Html\Img();
        if ($src !== null) {
            $obj->setSrc($src);
        }
        return $obj;
    }

    /**
     * Create an Input[type=image] element
     */
    final public static function imageInput() : Html\ImageInput
    {
        return new Html\ImageInput();
    }

    /**
     * Create an Ins element
     */
    final public static function ins() : Html\Ins
    {
        return new Html\Ins();
    }

    /**
     * Create an Kbd element
     */
    final public static function kbd() : Html\Kbd
    {
        return new Html\Kbd();
    }

    /**
     * Create an Label element
     */
    final public static function label() : Html\Label
    {
        return new Html\Label();
    }

    /**
     * Create an Li element
     */
    final public static function li() : Html\Li
    {
        return new Html\Li();
    }

    /**
     * Create an Main element
     */
    final public static function main() : Html\Main
    {
        return new Html\Main();
    }

    /**
     * Create an Mark element
     */
    final public static function mark() : Html\Mark
    {
        return new Html\Mark();
    }

    /**
     * Create an Nav element
     */
    final public static function nav() : Html\Nav
    {
        return new Html\Nav();
    }

    /**
     * Create an Input[type=number] element
     */
    final public static function numberInput() : Html\NumberInput
    {
        return new Html\NumberInput();
    }

    /**
     * Create an Ol element
     */
    final public static function ol() : Html\Ol
    {
        return new Html\Ol();
    }

    /**
     * Create an Option element
     */
    final public static function option() : Html\Option
    {
        return new Html\Option();
    }

    /**
     * Create an OptGroup element
     */
    final public static function optGroup() : Html\OptionGroup
    {
        return new Html\OptionGroup();
    }

    /**
     * Create an P element
     */
    final public static function p(string $text = null) : Html\P
    {
        $obj = new Html\P();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=password] element
     */
    final public static function passwordInput() : Html\PasswordInput
    {
        return new Html\PasswordInput();
    }

    /**
     * Create an Pre element
     */
    final public static function pre(string $text = null) : Html\Pre
    {
        $obj = new Html\Pre();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an q element
     */
    final public static function q(string $text = null) : Html\Q
    {
        $obj = new Html\Q();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=radio] element
     */
    final public static function radioInput() : Html\RadioInput
    {
        return new Html\RadioInput();
    }

    /**
     * Create an Input[type=range] element
     */
    final public static function rangeInput() : Html\RangeInput
    {
        return new Html\RangeInput();
    }

    /**
     * Create an Rb element
     */
    final public static function rb() : Html\Rb
    {
        return new Html\Rb();
    }

    /**
     * Create an Input[type=reset] element
     */
    final public static function resetInput() : Html\ResetInput
    {
        return new Html\ResetInput();
    }

    /**
     * Create an Rp element
     */
    final public static function rp() : Html\Rp
    {
        return new Html\Rp();
    }

    /**
     * Create an Rt element
     */
    final public static function rt() : Html\Rt
    {
        return new Html\Rt();
    }

    /**
     * Create an Rtc element
     */
    final public static function rtc() : Html\Rtc
    {
        return new Html\Rtc();
    }

    /**
     * Create an Ruby element
     */
    final public static function ruby() : Html\Ruby
    {
        return new Html\Ruby();
    }

    /**
     * Create an S element
     */
    final public static function s(string $text = null) : Html\S
    {
        $obj = new Html\S();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Samp element
     */
    final public static function samp() : Html\Samp
    {
        return new Html\Samp();
    }

    /**
     * Create an Input[type=search] element
     */
    final public static function searchInput() : Html\SearchInput
    {
        return new Html\SearchInput();
    }

    /**
     * Create an Section element
     */
    final public static function section() : Html\Section
    {
        return new Html\Section();
    }

    /**
     * Create an Select element
     */
    final public static function select() : Html\Select
    {
        return new Html\Select();
    }

    /**
     * Create an Small element
     */
    final public static function small(string $text = null) : Html\Small
    {
        $obj = new Html\Small();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Span element
     */
    final public static function span(string $text = null) : Html\Span
    {
        $obj = new Html\Span();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Strong element
     */
    final public static function strong(string $text = null) : Html\Strong
    {
        $obj = new Html\Strong();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Sub element
     */
    final public static function sub(string $text = null) : Html\Sub
    {
        $obj = new Html\Sub();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=submit] element
     */
    final public static function submitInput() : Html\SubmitInput
    {
        return new Html\SubmitInput();
    }

    /**
     * Create an Sup element
     */
    final public static function sup(string $text = null) : Html\Sup
    {
        $obj = new Html\Sup();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create a Table element
     */
    final public static function table() : Html\Table
    {
        return new Html\Table();
    }

    /**
     * Create a Tbody element
     */
    final public static function tbody() : Html\Tbody
    {
        return new Html\Tbody();
    }

    /**
     * Create a Thead element
     */
    final public static function thead() : Html\Thead
    {
        return new Html\Thead();
    }

    /**
     * Create a Tfoot element
     */
    final public static function tfoot() : Html\Tfoot
    {
        return new Html\Tfoot();
    }

    /**
     * Create a tr element
     */
    final public static function tr() : Html\Tr
    {
        return new Html\Tr();
    }

    /**
     * Create an Td element
     */
    final public static function td(string $text = null) : Html\Td
    {
        $obj = new Html\Td();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Th element
     */
    final public static function th(string $text = null) : Html\Th
    {
        $obj = new Html\Th();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Input[type=tel] element
     */
    final public static function telInput() : Html\TelInput
    {
        return new Html\TelInput();
    }

    /**
     * Create an Text element
     */
    final public static function text(string $text = null) : Html\Text
    {
        $obj = new Html\Text();
        if ($text !== null) {
            $obj->setText($text);
        }
        return $obj;
    }

    /**
     * Create an Textarea element
     */
    final public static function textarea() : Html\Textarea
    {
        return new Html\Textarea();
    }

    /**
     * Create an Input[type=text] element
     */
    final public static function textInput() : Html\TextInput
    {
        return new Html\TextInput();
    }

    /**
     * Create an Time element
     */
    final public static function time() : Html\Time
    {
        return new Html\Time();
    }

    /**
     * Create an Input[type=time] element
     */
    final public static function timeInput() : Html\TimeInput
    {
        return new Html\TimeInput();
    }

    /**
     * Create an U element
     */
    final public static function u(string $text = null) : Html\U
    {
        $obj = new Html\U();
        if ($text !== null) {
            $obj->add(self::text($text));
        }
        return $obj;
    }

    /**
     * Create an Ul element
     */
    final public static function ul() : Html\Ul
    {
        return new Html\Ul();
    }

    /**
     * Create an Input[type=url] element
     */
    final public static function urlInput() : Html\UrlInput
    {
        return new Html\UrlInput();
    }

    /**
     * Create an Var element
     */
    final public static function varElement() : Html\VarE
    {
        return new Html\VarE();
    }

    /**
     * Create an Wbr element
     */
    final public static function wbr() : Html\Wbr
    {
        return new Html\Wbr();
    }
}
