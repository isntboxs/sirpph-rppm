/* eslint-disable @typescript-eslint/no-unsafe-member-access */
/* eslint-disable @typescript-eslint/no-unsafe-assignment */
import { queryOptions } from '@tanstack/react-query'
import type { SessionSchema, SignInResponseSchema } from '#/schemas/auth.schema'
import { env } from '#/env'

const BASE_URL = env.VITE_BASE_API_URL

export const login = async (username: string, password: string) => {
  const response = await fetch(`${BASE_URL}/auth/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ username, password }),
  })

  if (response.ok) {
    const data = await response.json()
    return data.data as SignInResponseSchema
  }

  throw new Error('Login failed')
}

export const getCurrentUser = async (token: string) => {
  const response = await fetch(`${BASE_URL}/auth/me`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
  })

  if (response.ok) {
    const data = await response.json()
    return data.data as SessionSchema
  }

  return null
}

export const userQueryOptions = (token: string) => {
  return queryOptions({
    queryKey: ['user'],
    queryFn: () => getCurrentUser(token),
    staleTime: Infinity,
  })
}
