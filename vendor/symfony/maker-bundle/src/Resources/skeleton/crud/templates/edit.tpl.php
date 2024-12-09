<?= $helper->getHeadPrintCode('Modifier '.$entity_class_name) ?>

{% block body %}
    <h1>Modifier <?= $entity_class_name ?></h1>

    {{ include('<?= $templates_path ?>/_form.html.twig', {'button_label': 'Update'}) }}

    <a href="{{ path('<?= $route_name ?>_index') }}">Retour</a>

    {{ include('<?= $templates_path ?>/_delete_form.html.twig') }}
{% endblock %}
