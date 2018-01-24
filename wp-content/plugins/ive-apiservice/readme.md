# What is this?
This plugin will open your website API. So you can developing other application like a Mobile Application or anything and then connect to your website API.

## API Request
Set default api request to your home page and add URI `?api` for example `http://ivebox.com/?api`.

**Home Page:**

- `get [string]` : (list|detail)
- `type [int]` : Select post type
- `post_id [int]` : Select post id
- `category [string]` : (category_slug) list posts in category
- `paged [int]` : pagination parameter
- `search [string]` : search posts
- `active_event [string]` : (dd-mm-yyyy)

- `order [string]` : field to order
- `orderby [string]` : (ASC|DESC|RAND)
- `list_all [string]` : show all posts without limit

- `extra [string]` : Extra parameter request (slider)
- `output [string]` : (text|json)

## Output List

id
type
slug
datetime
thumbnail
thumbnail_medium
thumbnail_large
title
excerpt

- only on `event` post_type:
	category
	category_text
	active_event
	active_event_text

## Output Single
id
type
slug
date
thumbnail_large
content_html
similiars





