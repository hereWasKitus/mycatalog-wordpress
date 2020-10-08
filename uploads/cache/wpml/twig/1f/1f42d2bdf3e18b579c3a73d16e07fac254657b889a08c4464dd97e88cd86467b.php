<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* custom-files.twig */
class __TwigTemplate_5a85f7bb4ebcff6157354007190dc16c411c540d65596d6ac7c006d33ae6b7e2 extends \WPML\Core\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        if (($context["is_variation"] ?? null)) {
            // line 2
            echo "    <tr><td>
";
        }
        // line 4
        echo "
<div class=\"wcml-downloadable-options\">

    <input type=\"checkbox\" name=\"wcml_file_path_option[";
        // line 7
        echo \WPML\Core\twig_escape_filter($this->env, ($context["product_id"] ?? null), "html", null, true);
        echo "]\" id=\"wcml_file_path_option\" ";
        if (($context["sync_custom"] ?? null)) {
            echo " checked=\"checked\"";
        }
        echo " />
    <label for=\"wcml_file_path_option\">";
        // line 8
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "use_custom", []), "html", null, true);
        echo "</label>

    <ul ";
        // line 10
        if (twig_test_empty(($context["sync_custom"] ?? null))) {
            echo " style=\"display: none\"";
        }
        echo ">
        <li>
            <input type=\"radio\" name=\"wcml_file_path_sync[";
        // line 12
        echo \WPML\Core\twig_escape_filter($this->env, ($context["product_id"] ?? null), "html", null, true);
        echo "]\" value=\"auto\"
                    ";
        // line 13
        if (((($context["sync_custom"] ?? null) == "auto") || twig_test_empty(($context["sync_custom"] ?? null)))) {
            echo " checked=\"checked\"";
        }
        echo " id=\"wcml_file_path_sync_auto\" />
            <label for=\"wcml_file_path_sync_auto\">";
        // line 14
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "use_same", []), "html", null, true);
        echo "</label>
        </li>
        <li>
            <input type=\"radio\" name=\"wcml_file_path_sync[";
        // line 17
        echo \WPML\Core\twig_escape_filter($this->env, ($context["product_id"] ?? null), "html", null, true);
        echo "]\" value=\"self\"
                    ";
        // line 18
        if ((($context["sync_custom"] ?? null) == "self")) {
            echo " checked=\"checked\"";
        }
        echo " id=\"wcml_file_path_sync_self\" />
            <label for=\"wcml_file_path_sync_self\">";
        // line 19
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "separate", []), "html", null, true);
        echo "</label>
        </li>
    </ul>
    <p></p>
    ";
        // line 23
        echo ($context["nonce"] ?? null);
        echo "
</div>

";
        // line 26
        if (($context["is_variation"] ?? null)) {
            // line 27
            echo "    </td></tr>
";
        }
    }

    public function getTemplateName()
    {
        return "custom-files.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 27,  102 => 26,  96 => 23,  89 => 19,  83 => 18,  79 => 17,  73 => 14,  67 => 13,  63 => 12,  56 => 10,  51 => 8,  43 => 7,  38 => 4,  34 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "custom-files.twig", "D:\\Kitus\\Apps\\laragon\\www\\mycatalog\\wp-content\\plugins\\woocommerce-multilingual\\templates\\custom-files.twig");
    }
}
