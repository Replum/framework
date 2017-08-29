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
    final public static function a(PageInterface $page) : Html\A
    {
        return new Html\A($page);
    }

    /**
     * Create an Abbr element
     */
    final public static function abbr(PageInterface $page) : Html\Abbr
    {
        return new Html\Abbr($page);
    }

    /**
     * Create an Address element
     */
    final public static function address(PageInterface $page) : Html\Address
    {
        return new Html\Address($page);
    }

    /**
     * Create an Article element
     */
    final public static function article(PageInterface $page) : Html\Article
    {
        return new Html\Article($page);
    }

    /**
     * Create an Aside element
     */
    final public static function aside(PageInterface $page) : Html\Aside
    {
        return new Html\Aside($page);
    }

    /**
     * Create an B element
     */
    final public static function b(PageInterface $page) : Html\B
    {
        return new Html\B($page);
    }

    /**
     * Create an Bdi element
     */
    final public static function bdi(PageInterface $page) : Html\Bdi
    {
        return new Html\Bdi($page);
    }

    /**
     * Create an Bdo element
     */
    final public static function bdo(PageInterface $page) : Html\Bdo
    {
        return new Html\Bdo($page);
    }

    /**
     * Create an Blockquote element
     */
    final public static function blockquote(PageInterface $page) : Html\Blockquote
    {
        return new Html\Blockquote($page);
    }

    /**
     * Create an Body element
     */
    final public static function body(PageInterface $page) : Html\Body
    {
        return new Html\Body($page);
    }

    /**
     * Create an Button element
     */
    final public static function button(PageInterface $page) : Html\Button
    {
        return new Html\Button($page);
    }

    /**
     * Create an Input[type=button] element
     */
    final public static function buttonInput(PageInterface $page) : Html\ButtonInput
    {
        return new Html\ButtonInput($page);
    }

    /**
     * Create an Input[type=checkbox] element
     */
    final public static function checkboxInput(PageInterface $page) : Html\CheckboxInput
    {
        return new Html\CheckboxInput($page);
    }

    /**
     * Create an Cite element
     */
    final public static function cite(PageInterface $page) : Html\Cite
    {
        return new Html\Cite($page);
    }

    /**
     * Create an Code element
     */
    final public static function code(PageInterface $page) : Html\Code
    {
        return new Html\Code($page);
    }

    /**
     * Create an Input[type=color] element
     */
    final public static function colorInput(PageInterface $page) : Html\ColorInput
    {
        return new Html\ColorInput($page);
    }

    /**
     * Create an Data element
     */
    final public static function data(PageInterface $page) : Html\Data
    {
        return new Html\Data($page);
    }

    /**
     * Create an Input[type=date] element
     */
    final public static function dateInput(PageInterface $page) : Html\DateInput
    {
        return new Html\DateInput($page);
    }

    /**
     * Create an Dd element
     */
    final public static function dd(PageInterface $page) : Html\Dd
    {
        return new Html\Dd($page);
    }

    /**
     * Create an Del element
     */
    final public static function del(PageInterface $page) : Html\Del
    {
        return new Html\Del($page);
    }

    /**
     * Create an Dfn element
     */
    final public static function dfn(PageInterface $page) : Html\Dfn
    {
        return new Html\Dfn($page);
    }

    /**
     * Create an Div element
     */
    final public static function div(PageInterface $page) : Html\Div
    {
        return new Html\Div($page);
    }

    /**
     * Create an Dl element
     */
    final public static function dl(PageInterface $page) : Html\Dl
    {
        return new Html\Dl($page);
    }

    /**
     * Create an Dt element
     */
    final public static function dt(PageInterface $page) : Html\Dt
    {
        return new Html\Dt($page);
    }

    /**
     * Create an Em element
     */
    final public static function em(PageInterface $page) : Html\Em
    {
        return new Html\Em($page);
    }

    /**
     * Create an Input[type=email] element
     */
    final public static function emailInput(PageInterface $page) : Html\EmailInput
    {
        return new Html\EmailInput($page);
    }

    /**
     * Create an FigCaption element
     */
    final public static function figCaption(PageInterface $page) : Html\FigCaption
    {
        return new Html\FigCaption($page);
    }

    /**
     * Create an Figure element
     */
    final public static function figure(PageInterface $page) : Html\Figure
    {
        return new Html\Figure($page);
    }

    /**
     * Create an Input[type=file] element
     */
    final public static function fileInput(PageInterface $page) : Html\FileInput
    {
        return new Html\FileInput($page);
    }

    /**
     * Create an Footer element
     */
    final public static function footer(PageInterface $page) : Html\Footer
    {
        return new Html\Footer($page);
    }

    /**
     * Create an Form element
     */
    final public static function form(PageInterface $page) : Html\Form
    {
        return new Html\Form($page);
    }

    /**
     * Create an H1 element
     */
    final public static function h1(PageInterface $page) : Html\H1
    {
        return new Html\H1($page);
    }

    /**
     * Create an H2 element
     */
    final public static function h2(PageInterface $page) : Html\H2
    {
        return new Html\H2($page);
    }

    /**
     * Create an H3 element
     */
    final public static function h3(PageInterface $page) : Html\H3
    {
        return new Html\H3($page);
    }

    /**
     * Create an H4 element
     */
    final public static function h4(PageInterface $page) : Html\H4
    {
        return new Html\H4($page);
    }

    /**
     * Create an H5 element
     */
    final public static function h5(PageInterface $page) : Html\H5
    {
        return new Html\H5($page);
    }

    /**
     * Create an H6 element
     */
    final public static function h6(PageInterface $page) : Html\H6
    {
        return new Html\H6($page);
    }

    /**
     * Create an Header element
     */
    final public static function header(PageInterface $page) : Html\Header
    {
        return new Html\Header($page);
    }

    /**
     * Create an Input[type=hidden] element
     */
    final public static function hiddenInput(PageInterface $page) : Html\HiddenInput
    {
        return new Html\HiddenInput($page);
    }

    /**
     * Create an Hr element
     */
    final public static function hr(PageInterface $page) : Html\Hr
    {
        return new Html\Hr($page);
    }

    /**
     * Create an I element
     */
    final public static function i(PageInterface $page) : Html\I
    {
        return new Html\I($page);
    }

    /**
     * Create an Img element
     */
    final public static function img(PageInterface $page) : Html\Image
    {
        return new Html\Image($page);
    }

    /**
     * Create an Input[type=image] element
     */
    final public static function imageInput(PageInterface $page) : Html\ImageInput
    {
        return new Html\ImageInput($page);
    }

    /**
     * Create an Ins element
     */
    final public static function ins(PageInterface $page) : Html\Ins
    {
        return new Html\Ins($page);
    }

    /**
     * Create an Kbd element
     */
    final public static function kbd(PageInterface $page) : Html\Kbd
    {
        return new Html\Kbd($page);
    }

    /**
     * Create an Label element
     */
    final public static function label(PageInterface $page) : Html\Label
    {
        return new Html\Label($page);
    }

    /**
     * Create an Li element
     */
    final public static function li(PageInterface $page) : Html\Li
    {
        return new Html\Li($page);
    }

    /**
     * Create an Main element
     */
    final public static function main(PageInterface $page) : Html\Main
    {
        return new Html\Main($page);
    }

    /**
     * Create an Mark element
     */
    final public static function mark(PageInterface $page) : Html\Mark
    {
        return new Html\Mark($page);
    }

    /**
     * Create an Nav element
     */
    final public static function nav(PageInterface $page) : Html\Nav
    {
        return new Html\Nav($page);
    }

    /**
     * Create an Input[type=number] element
     */
    final public static function numberInput(PageInterface $page) : Html\NumberInput
    {
        return new Html\NumberInput($page);
    }

    /**
     * Create an Ol element
     */
    final public static function ol(PageInterface $page) : Html\Ol
    {
        return new Html\Ol($page);
    }

    /**
     * Create an Option element
     */
    final public static function option(PageInterface $page) : Html\Option
    {
        return new Html\Option($page);
    }

    /**
     * Create an OptGroup element
     */
    final public static function optGroup(PageInterface $page) : Html\OptionGroup
    {
        return new Html\OptionGroup($page);
    }

    /**
     * Create an P element
     */
    final public static function p(PageInterface $page) : Html\P
    {
        return new Html\P($page);
    }

    /**
     * Create an Input[type=password] element
     */
    final public static function passwordInput(PageInterface $page) : Html\PasswordInput
    {
        return new Html\PasswordInput($page);
    }

    /**
     * Create an Pre element
     */
    final public static function pre(PageInterface $page) : Html\Pre
    {
        return new Html\Pre($page);
    }

    /**
     * Create an q element
     */
    final public static function q(PageInterface $page) : Html\Q
    {
        return new Q($page);
    }

    /**
     * Create an Input[type=radio] element
     */
    final public static function radioInput(PageInterface $page) : Html\RadioInput
    {
        return new Html\RadioInput($page);
    }

    /**
     * Create an Input[type=range] element
     */
    final public static function rangeInput(PageInterface $page) : Html\RangeInput
    {
        return new Html\RangeInput($page);
    }

    /**
     * Create an Rb element
     */
    final public static function rb(PageInterface $page) : Html\Rb
    {
        return new Html\Rb($page);
    }

    /**
     * Create an Input[type=reset] element
     */
    final public static function resetInput(PageInterface $page) : Html\ResetInput
    {
        return new Html\ResetInput($page);
    }

    /**
     * Create an Rp element
     */
    final public static function rp(PageInterface $page) : Html\Rp
    {
        return new Html\Rp($page);
    }

    /**
     * Create an Rt element
     */
    final public static function rt(PageInterface $page) : Html\Rt
    {
        return new Html\Rt($page);
    }

    /**
     * Create an Rtc element
     */
    final public static function rtc(PageInterface $page) : Html\Rtc
    {
        return new Html\Rtc($page);
    }

    /**
     * Create an Ruby element
     */
    final public static function ruby(PageInterface $page) : Html\Ruby
    {
        return new Html\Ruby($page);
    }

    /**
     * Create an S element
     */
    final public static function s(PageInterface $page) : Html\S
    {
        return new Html\S($page);
    }

    /**
     * Create an Samp element
     */
    final public static function samp(PageInterface $page) : Html\Samp
    {
        return new Html\Samp($page);
    }

    /**
     * Create an Input[type=search] element
     */
    final public static function searchInput(PageInterface $page) : Html\SearchInput
    {
        return new Html\SearchInput($page);
    }

    /**
     * Create an Section element
     */
    final public static function section(PageInterface $page) : Html\Section
    {
        return new Html\Section($page);
    }

    /**
     * Create an Small element
     */
    final public static function small(PageInterface $page) : Html\Small
    {
        return new Html\Small($page);
    }

    /**
     * Create an Span element
     */
    final public static function span(PageInterface $page) : Html\Span
    {
        return new Html\Span($page);
    }

    /**
     * Create an Strong element
     */
    final public static function strong(PageInterface $page) : Html\Strong
    {
        return new Html\Strong($page);
    }

    /**
     * Create an Sub element
     */
    final public static function sub(PageInterface $page) : Html\Sub
    {
        return new Html\Sub($page);
    }

    /**
     * Create an Input[type=submit] element
     */
    final public static function submitInput(PageInterface $page) : Html\SubmitInput
    {
        return new Html\SubmitInput($page);
    }

    /**
     * Create an Sup element
     */
    final public static function sup(PageInterface $page) : Html\Sup
    {
        return new Html\Sup($page);
    }

    /**
     * Create an Input[type=tel] element
     */
    final public static function telInput(PageInterface $page) : Html\TelInput
    {
        return new Html\TelInput($page);
    }

    /**
     * Create an Text element
     */
    final public static function text(PageInterface $page) : Html\Text
    {
        return new Html\Text($page);
    }

    /**
     * Create an Input[type=text] element
     */
    final public static function textInput(PageInterface $page) : Html\TextInput
    {
        return new Html\TextInput($page);
    }

    /**
     * Create an Time element
     */
    final public static function time(PageInterface $page) : Html\Time
    {
        return new Html\Time($page);
    }

    /**
     * Create an Input[type=time] element
     */
    final public static function timeInput(PageInterface $page) : Html\TimeInput
    {
        return new Html\TimeInput($page);
    }

    /**
     * Create an U element
     */
    final public static function u(PageInterface $page) : Html\U
    {
        return new Html\U($page);
    }

    /**
     * Create an Ul element
     */
    final public static function ul(PageInterface $page) : Html\Ul
    {
        return new Html\Ul($page);
    }

    /**
     * Create an Input[type=url] element
     */
    final public static function urlInput(PageInterface $page) : Html\UrlInput
    {
        return new Html\UrlInput($page);
    }

    /**
     * Create an Var element
     */
    final public static function varElement(PageInterface $page) : Html\VarE
    {
        return new Html\VarE($page);
    }

    /**
     * Create an Wbr element
     */
    final public static function wbr(PageInterface $page) : Html\Wbr
    {
        return new Html\Wbr($page);
    }
}
