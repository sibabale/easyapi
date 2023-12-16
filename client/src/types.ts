export type Project = {
  id: number
  name: string
  api_type: 'Rest' | 'GraphQL'
  database: string
  api_version: number
  description: string
}

export type Enpoint = {
  name: string
  type: null | 'Boolen' | 'Float' | 'Int' | 'Text' | 'varchar(20)' | 'varchar(255)'
}
