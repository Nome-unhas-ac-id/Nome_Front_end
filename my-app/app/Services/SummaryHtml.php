<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

class SummaryHtml
{
    /** Allow formatting only; remove scripts, resources, links and every attribute. */
    public static function clean(?string $html): string
    {
        if (! $html) {
            return '';
        }
        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<?xml encoding="UTF-8"><body>'.$html.'</body>', LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
            $body = $document->getElementsByTagName('body')->item(0);
            if (! $body) {
                return '';
            }
            self::sanitize($body);
            $result = '';
            foreach ($body->childNodes as $child) {
                $result .= $document->saveHTML($child);
            }

            return $result;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }

    private static function sanitize(DOMNode $parent): void
    {
        $allowed = ['p', 'br', 'hr', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'strong', 'em', 'b', 'i', 'table', 'thead', 'tbody', 'tr', 'td', 'th', 'blockquote'];
        foreach (iterator_to_array($parent->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math', 'template', 'img', 'video', 'audio', 'link'], true)) {
                    $parent->removeChild($child);

                    continue;
                }
                self::sanitize($child);
                if (! in_array($tag, $allowed, true)) {
                    while ($child->firstChild) {
                        $parent->insertBefore($child->firstChild, $child);
                    }
                    $parent->removeChild($child);

                    continue;
                }
                while ($child->attributes->length) {
                    $child->removeAttributeNode($child->attributes->item(0));
                }
            } elseif ($child->nodeType !== XML_TEXT_NODE) {
                $parent->removeChild($child);
            }
        }
    }
}
