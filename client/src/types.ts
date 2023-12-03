export type Project = {
  id: number
  name: string
  api_type: 'Rest' | 'GraphQL'
  database: string
  api_version: number
  description: string
}
