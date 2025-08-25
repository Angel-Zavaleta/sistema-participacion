import { describe, it, expect } from 'vitest'
import { render, screen } from '@testing-library/react'
import React from 'react'

// Ejemplo de componente simple para testing
function Welcome({ name }: { name: string }) {
  return <h1>Welcome, {name}!</h1>
}

describe('Welcome Component', () => {
  it('renders welcome message with name', () => {
    render(<Welcome name="John" />)
    expect(screen.getByText('Welcome, John!')).toBeInTheDocument()
  })

  it('renders with different names', () => {
    render(<Welcome name="Jane" />)
    expect(screen.getByText('Welcome, Jane!')).toBeInTheDocument()
  })
})
