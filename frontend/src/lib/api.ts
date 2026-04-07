/* eslint-disable @typescript-eslint/no-unsafe-assignment */
import { queryOptions } from '@tanstack/react-query'
import type {
  SessionSchema,
  SignInErrorSchema,
  SignInResponseSchema,
} from '#/schemas/auth.schema'

export const login = async (username: string, password: string) => {
  const response = await fetch(`/api/auth/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    credentials: 'include',
    body: JSON.stringify({ username, password }),
  })

  const data = await response.json()

  if (!response.ok) {
    return data as SignInErrorSchema
  }

  return data as SignInResponseSchema
}

export const getCurrentUser = async () => {
  const response = await fetch(`/api/auth/me`, {
    method: 'GET',
    headers: {
      Accept: 'application/json',
      Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
    },
    credentials: 'include',
  })
  const data = await response.json()

  if (response.ok) {
    return data as SessionSchema
  }

  return data as { message: string }
}

export const userQueryOptions = () => {
  return queryOptions({
    queryKey: ['user'],
    queryFn: getCurrentUser,
    staleTime: Infinity,
  })
}
