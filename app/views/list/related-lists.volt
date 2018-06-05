{% for relatedTable in related %}
  {{ partial('partials/list-card', [
    'id': relatedTable['id'],
    'slug': relatedTable['slug'],
    'image': relatedTable['image'],
    'name': relatedTable['name'],
    'description': relatedTable['description'],
    'subscriberCount': relatedTable['subscriberCount'],
    'showCurator': true,
    'curatorHandle': relatedTable['curatorHandle'],
    'curatorAvatar': relatedTable['curatorImage'],
    'curatorName': relatedTable['curatorName'],
    'curatorBio': relatedTable['curatorBio'],
    'small': true,
    'half': false,
    'large': false
  ]) }}
{% endfor %}
