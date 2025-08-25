import '@testing-library/jest-dom'
import { vi } from 'vitest'
import React from 'react'

// Global test setup
global.ResizeObserver = vi.fn().mockImplementation(() => ({
  observe: vi.fn(),
  unobserve: vi.fn(),
  disconnect: vi.fn(),
}))

// Mock InertiaJS
vi.mock('@inertiajs/react', () => ({
  usePage: () => ({
    props: {},
    url: '/',
    component: 'Test'
  }),
  router: {
    visit: vi.fn(),
    get: vi.fn(),
    post: vi.fn(),
    put: vi.fn(),
    patch: vi.fn(),
    delete: vi.fn(),
  },
  Link: ({ children, ...props }: { children: React.ReactNode; [key: string]: unknown }) => 
    React.createElement('a', props, children),
  Head: ({ children }: { children: React.ReactNode }) => 
    React.createElement('head', {}, children),
}))
