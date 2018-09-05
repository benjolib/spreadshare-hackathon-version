<input class="moreItemsAvailable" type="hidden" value="{{ moreItemsAvailable }}" />

{% for table in tables %}
    {{ partial('partials/list-card', [
        'id': table['id'],
        'slug': table['slug'],
        'image': table['image'],
        'name': table['title'],
        'description': table['tagline'],
        'subscriberCount': table['subscriberCount'],
        'listingCount': table['listingCount'],
        'showCurator': true,
        'curatorHandle': table['creatorHandle'],
        'curatorAvatar': table['creatorImage'],
        'curatorName': table['creator'],
        'curatorBio': table['creatorBio'],
        'half': false,
        'large': false
    ]) }}
{% endfor %}
