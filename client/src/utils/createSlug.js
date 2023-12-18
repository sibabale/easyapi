import slugify from 'slugify'

const createSlug  = (slug, replacement) => slugify(slug, {
  replacement: `${replacement}`,
  lower: true,
  strict: true
})

export default createSlug;